@extends('layouts.user_type.auth')

@section('content')
    <div id="consultation-container">
        <h1>Consultation Room</h1>
        <button id="start-btn" class="btn btn-success">Start Consultation</button>
        <button id="join-btn" style="display: none;" class="btn btn-primary">Join Room</button>
        <div id="video-container" style="display: flex; flex-wrap: wrap; margin-top: 20px;"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const startBtn = document.getElementById('start-btn');


            const userId = '{{ auth()->user()->id }}';

            Echo.private(`consultation.${userId}`)
                .listen('ConsultationStarted', (e) => {
                    alert(`Consultation started by Dr. ${e.doctorName}! Room Name: ${e.roomName}`);
                    const joinBtn = document.getElementById('join-btn');
                    joinBtn.style.display = 'block';
                    joinBtn.addEventListener('click', () => joinRoom(e.roomName));
                });

            const startConsultation = async () => {
                const response = await fetch('{{ route('consultation.start') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();
                joinRoom(data.roomName);
            };
            startBtn.addEventListener('click', startConsultation);
            const joinRoom = async (roomName) => {
                const response = await fetch('/generate-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        roomName: roomName,
                        participantName: 'participant-{{ auth()->user()->id }}'
                    })
                });

                const data = await response.json();
                const { token } = data;

                const room = new LiveKit.Room();
                await room.connect('{{ config('livekit.host') }}', token);

                room.on('participant-connected', (participant) => {
                    console.log('Participant connected:', participant);
                    addParticipantVideo(participant);
                });

                room.on('participant-disconnected', (participant) => {
                    console.log('Participant disconnected:', participant);
                    removeParticipantVideo(participant);
                });

                const addParticipantVideo = (participant) => {
                    participant.on('track-subscribed', (track, publication) => {
                        if (track.kind === 'video') {
                            const videoElement = track.attach();
                            videoElement.id = `video-${participant.identity}`;
                            document.getElementById('video-container').appendChild(videoElement);
                        }
                    });

                    participant.on('track-unsubscribed', (track, publication) => {
                        if (track.kind === 'video') {
                            const videoElement = document.getElementById(`video-${participant.identity}`);
                            if (videoElement) {
                                track.detach().forEach(element => element.remove());
                            }
                        }
                    });

                    participant.tracks.forEach(publication => {
                        if (publication.isSubscribed && publication.track.kind === 'video') {
                            const videoElement = publication.track.attach();
                            videoElement.id = `video-${participant.identity}`;
                            document.getElementById('video-container').appendChild(videoElement);
                        }
                    });
                };

                const removeParticipantVideo = (participant) => {
                    const videoElement = document.getElementById(`video-${participant.identity}`);
                    if (videoElement) {
                        videoElement.remove();
                    }
                };

                addParticipantVideo(room.localParticipant);
            };
        });
    </script>
@endsection
