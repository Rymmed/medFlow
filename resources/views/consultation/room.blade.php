<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Consultation Room</title>
    <!-- Include LiveKit SDK -->
    <script src="https://cdn.jsdelivr.net/npm/livekit-client/dist/livekit-client.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"/>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Online Consultation Room</h2>
            <!-- Video elements for the doctor and patient -->
            <video id="local-video" autoplay playsinline style="width: 100%; max-width: 480px; border: 1px solid #ccc;"></video>
            <video id="remote-video" autoplay playsinline style="width: 100%; max-width: 480px; border: 1px solid #ccc;"></video>
        </div>
        <div class="col-md-4">
            <h3>Controls</h3>
            <button id="toggle-audio-button" class="btn btn-secondary mt-1" disabled type="button">Enable Mic</button>
            <button id="toggle-video-button" class="btn btn-secondary mt-1" disabled type="button">Enable Camera</button>
            <button id="flip-video-button" class="btn btn-secondary mt-1" disabled type="button">Flip Camera</button>
            <button id="share-screen-button" class="btn btn-secondary mt-1" disabled type="button">Share Screen</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function () {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            try {
                document.getElementById('local-video').srcObject = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
            } catch (err) {
                console.error('Error accessing camera:', err);
            }
        } else {
            console.warn('getUserMedia not supported');
        }

        const doctorToken = "{{ $doctorToken }}";
        const patientToken = "{{ $patientToken }}";
        const serverUrl = "{{ env('LIVEKIT_URL') }}";

        const room = new LivekitClient.Room({
            adaptiveStream: true,
            dynacast: true,
            videoCaptureDefaults: {
                resolution: LivekitClient.VideoPresets.h720.resolution,
                frameRate: 30,
            },
        });

        try {
            const token = "{{ auth()->user()->role === 'doctor' ? $doctorToken : $patientToken }}";
            await room.connect(serverUrl, token);

            console.log('Connected as a', "{{ auth()->user()->role }}", 'to room', room.name);

            await room.localParticipant.setCameraEnabled(true);

            const localVideoTrack = room.localParticipant.getTrackPublication(LivekitClient.Track.Source.Camera);
            if (localVideoTrack && localVideoTrack.track) {
                localVideoTrack.track.attach(document.getElementById('local-video'));
            }

            room
                .on(LivekitClient.RoomEvent.TrackSubscribed, handleTrackSubscribed)
                .on(LivekitClient.RoomEvent.TrackUnsubscribed, handleTrackUnsubscribed)
                .on(LivekitClient.RoomEvent.Disconnected, handleDisconnect)
                .on(LivekitClient.RoomEvent.LocalTrackUnpublished, handleLocalTrackUnpublished);

        } catch (error) {
            console.error('Error connecting to room:', error);
        }

        function handleTrackSubscribed(track, publication, participant) {
            if (track.kind === LivekitClient.Track.Kind.Video || track.kind === LivekitClient.Track.Kind.Audio) {
                const element = track.attach();
                const parentElement = document.getElementById('remote-video');
                parentElement.appendChild(element);
            }
        }




        function handleTrackUnsubscribed(track, publication, participant) {
            track.detach();
        }

        function handleLocalTrackUnpublished(publication, participant) {
            publication.track.detach();
        }

        function handleDisconnect() {
            console.log('Disconnected from room');
        }
    });

</script>
</body>
</html>
