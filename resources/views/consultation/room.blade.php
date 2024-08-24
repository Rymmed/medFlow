@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h2>Salle de consultation en ligne</h2>
        @if(auth()->user()->role === 'doctor')
            <a href="{{ route('consultationReport.create', ['appointment_id' => $appointment->id]) }}"
               class="btn bg-gradient-blue text-white btn-md" target="_blank"><i class="far fa-plus me-1"></i>Rapport de consultation</a>
        @endif
        <div class="video-container">
            <video id="local-video" class="video-small" autoplay playsinline></video>
            <video id="remote-video" class="video-large" autoplay playsinline></video>
        </div>
        <div class="controls">
            <button id="toggle-video-size-button" class="control-button" type="button">
                <i class="fas fa-exchange-alt"></i>
            </button>
            <button id="toggle-audio-button" class="control-button" type="button">
                <i class="fas fa-microphone"></i>
            </button>
            <button id="toggle-video-button" class="control-button" type="button">
                <i class="fas fa-video"></i>
            </button>
{{--            <button id="flip-video-button" class="control-button" disabled type="button">--}}
{{--                <i class="fas fa-sync-alt"></i>--}}
{{--            </button>--}}
            <button id="share-screen-button" class="control-button" type="button">
                <i class="fas fa-desktop"></i>
            </button>
            <button id="end-call-button" class="control-button end-call" type="button">
                <i class="fas fa-phone-slash"></i>
            </button>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const localVideoElement = document.getElementById('local-video');
            const remoteVideoElement = document.getElementById('remote-video');
            const endCallButton = document.getElementById('end-call-button');
            const toggleAudioButton = document.getElementById('toggle-audio-button');
            const toggleVideoButton = document.getElementById('toggle-video-button');
            // const flipVideoButton = document.getElementById('flip-video-button');
            const shareScreenButton = document.getElementById('share-screen-button');

            let room;
            let isAudioEnabled = true;
            let isVideoEnabled = true;
            let isScreenSharing = false;

            // Check for media devices availability
            if (navigator.mediaDevices?.getUserMedia) {
                try {
                    localVideoElement.srcObject = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                } catch (err) {
                    console.error('Error accessing camera :', err);
                }
            } else {
                console.warn('getUserMedia not supported');
            }

            const serverUrl = "{{ env('LIVEKIT_URL') }}";
            const token = "{{ auth()->user()->role === 'doctor' ? $doctorToken : $patientToken }}";
            const identity = "{{ auth()->user()->role === 'doctor' ? 'Doctor' : 'Patient' }}";

            try {
                // creates a new room with options
                room = new LivekitClient.Room({
                    adaptiveStream: true,
                    dynacast: true,
                    videoCaptureDefaults: {
                        resolution: LivekitClient.VideoPresets.h720.resolution,
                        frameRate: 30,
                    },
                });

                // pre-warm connection, this can be called as early as your page is loaded
                room.prepareConnection(serverUrl, token);

                // set up event listeners
                // connect to room

                room
                    .on(LivekitClient.RoomEvent.TrackSubscribed, handleTrackSubscribed)
                    .on(LivekitClient.RoomEvent.TrackUnsubscribed, handleTrackUnsubscribed)
                    .on(LivekitClient.RoomEvent.LocalTrackUnpublished, handleLocalTrackUnpublished)
                    .on(LivekitClient.RoomEvent.ParticipantConnected, participant => {
                        console.log('Participant connected :', participant.identity);
                        handleParticipantConnected(participant);
                    })
                    .on(LivekitClient.RoomEvent.ParticipantDisconnected, participant => {
                        console.log('Participant disconnected :', participant.identity);
                    })
                    .on(LivekitClient.RoomEvent.Disconnected, handleDisconnect);
                await room.connect(serverUrl, token);
                console.log(`${identity} connected to room :`, room.name);

                // publish local camera and mic tracks
                await room.localParticipant.enableCameraAndMicrophone();

                const localVideoTrack = room.localParticipant.getTrackPublication(LivekitClient.Track.Source.Camera);
                localVideoTrack?.track?.attach(localVideoElement);

                toggleAudioButton.disabled = false;
                toggleVideoButton.disabled = false;
                // flipVideoButton.disabled = false;
                shareScreenButton.disabled = false;

            } catch (error) {
                console.error('Error connecting to room :', error);
            }

            // Toggle audio on/off
            toggleAudioButton.addEventListener('click', () => {
                isAudioEnabled = !isAudioEnabled;
                room.localParticipant.setMicrophoneEnabled(isAudioEnabled);
                toggleAudioButton.querySelector('i').classList.toggle('fa-microphone');
                toggleAudioButton.querySelector('i').classList.toggle('fa-microphone-slash');
            });

            // Toggle video on/off
            toggleVideoButton.addEventListener('click', () => {
                isVideoEnabled = !isVideoEnabled;
                room.localParticipant.setCameraEnabled(isVideoEnabled);
                toggleVideoButton.querySelector('i').classList.toggle('fa-video');
                toggleVideoButton.querySelector('i').classList.toggle('fa-video-slash');
            });

            // Flip camera (if supported)
            // flipVideoButton.addEventListener('click', async () => {
            //     if (room.localParticipant) {
            //         const currentCamera = room.localParticipant.getTrackPublication(LivekitClient.Track.Source.Camera);
            //         if (currentCamera) {
            //             await room.localParticipant.switchCamera();
            //             console.log('Camera flipped');
            //         }
            //     }
            // });

            // Share screen
            shareScreenButton.addEventListener('click', async () => {
                if (!isScreenSharing) {
                    try {
                        await room.localParticipant.setScreenShareEnabled(true);
                        shareScreenButton.querySelector('i').classList.add('fa-stop');
                        shareScreenButton.querySelector('i').classList.remove('fa-desktop');
                        isScreenSharing = true;
                    } catch (error) {
                        console.error('Error sharing screen:', error);
                    }
                } else {
                    await room.localParticipant.setScreenShareEnabled(false);
                    shareScreenButton.querySelector('i').classList.remove('fa-stop');
                    shareScreenButton.querySelector('i').classList.add('fa-desktop');
                    isScreenSharing = false;
                }
            });
            // Gestionnaire pour le bouton "Finir l'appel"
            endCallButton.addEventListener('click', async function () {
                if (room) {
                    room.disconnect();
                    console.log('Call ended and disconnected from room');

                    // Update appointment status and redirect
                    await updateAppointmentStatus();
                    window.location.href = '/myAppointments/{{ $appointment->id }}/patient/{{ $appointment->patient_id }}/record';
                }
            });
            function handleTrackSubscribed(track, publication, participant) {
                console.log('Track subscribed :', track.kind, 'from', participant.identity);
                if (track.kind === LivekitClient.Track.Kind.Video || track.kind === LivekitClient.Track.Kind.Audio) {
                    track.attach(remoteVideoElement);
                }
            }

            function handleLocalTrackUnpublished(publication) {
                // when local tracks are ended, update UI to remove them from rendering
                publication.track.detach();
            }

            // Gérer l'annulation de la subscription d'une piste
            function handleTrackUnsubscribed(track, publication, participant) {
                console.log('Track unsubscribed :', track.kind, 'from', participant.identity);
                // remove tracks from all attached elements
                track.detach();
            }

            // Gérer la déconnexion de la salle
            function handleDisconnect() {
                // room.disconnect();
                console.log('Disconnected from room');
                updateAppointmentStatus();
            }

            function handleParticipantConnected(participant) {
                if (participant.isCameraEnabled) {
                    const publication = participant.getTrackPublication(LivekitClient.Track.Source.Camera);
                    if (publication?.isSubscribed) {
                        const videoElement = publication.videoTrack?.attach();
                        if (videoElement) {
                            remoteVideoElement.appendChild(videoElement);
                        }
                    }
                }
            }

            // Mise à jour du statut de l'appointment
            async function updateAppointmentStatus() {
                try {
                    const response = await fetch('/appointment/completed/{{ $appointment->id }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    });
                    const data = await response.json();
                    console.log('Appointment status updated:', data);
                } catch (error) {
                    console.error('Error updating appointment status:', error);
                }
            }



        });
        document.getElementById('toggle-video-size-button').addEventListener('click', function () {
            let localVideo = document.getElementById('local-video');
            let remoteVideo = document.getElementById('remote-video');

            if (localVideo.classList.contains('video-large')) {
                localVideo.classList.remove('video-large');
                localVideo.classList.add('video-small');
                remoteVideo.classList.remove('video-small');
                remoteVideo.classList.add('video-large');
            } else {
                localVideo.classList.remove('video-small');
                localVideo.classList.add('video-large');
                remoteVideo.classList.remove('video-large');
                remoteVideo.classList.add('video-small');
            }
        });
    </script>
@endsection
