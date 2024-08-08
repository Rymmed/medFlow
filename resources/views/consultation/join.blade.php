@extends('layouts.user_type.auth')

@section('content')
    <div id="consultation-container">
        <h1>Consultation Room: {{ $roomName }}</h1>
        <p>Token: {{ $token }}</p>
        <!-- LiveKit Video Container -->
        <div id="video-container" style="display: flex; flex-wrap: wrap;"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roomName = "{{ $roomName }}";
            const token = "{{ $token }}";
            const livekitUrl = "{{ config('app.livekit_url') }}";
            const videoContainer = document.getElementById('video-container');

            const connectToRoom = async () => {
                const room = new LiveKit.Room();
                await room.connect(livekitUrl, token);

                // Handle participant events, like joining or leaving
                room.on('participant-connected', (participant) => {
                    console.log('Participant connected:', participant);
                    addParticipantVideo(participant);
                });

                room.on('participant-disconnected', (participant) => {
                    console.log('Participant disconnected:', participant);
                    removeParticipantVideo(participant);
                });

                // Add local participant video
                addParticipantVideo(room.localParticipant);
            };

            const addParticipantVideo = (participant) => {
                participant.on('track-subscribed', (track, publication) => {
                    if (track.kind === 'video') {
                        const videoElement = track.attach();
                        videoElement.id = `video-${participant.identity}`;
                        videoContainer.appendChild(videoElement);
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

                // Subscribe to already published tracks
                participant.tracks.forEach(publication => {
                    if (publication.isSubscribed && publication.track.kind === 'video') {
                        const videoElement = publication.track.attach();
                        videoElement.id = `video-${participant.identity}`;
                        videoContainer.appendChild(videoElement);
                    }
                });
            };

            const removeParticipantVideo = (participant) => {
                const videoElement = document.getElementById(`video-${participant.identity}`);
                if (videoElement) {
                    videoElement.remove();
                }
            };

            connectToRoom().catch(console.error);
        });
    </script>
@endsection
