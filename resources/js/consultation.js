import {
    Room,
    RoomEvent,
    VideoPresets,
    createLocalTracks,
    LocalTrackPublication,
    LocalParticipant,
    RemoteTrack,
    RemoteTrackPublication,
    RemoteParticipant,
} from 'livekit-client';

async function startLiveKitRoom(roomUrl, token) {
    // creates a new room with options
    const room = new Room({
        // automatically manage subscribed video quality
        adaptiveStream: true,

        // optimize publishing bandwidth and CPU for published tracks
        dynacast: true,

        // default capture settings
        videoCaptureDefaults: {
            resolution: VideoPresets.h720.resolution,
        },
    });

    // pre-warm connection, this can be called as early as your page is loaded
    await room.prepareConnection(roomUrl, token);

    // set up event listeners
    room
        .on(RoomEvent.TrackSubscribed, handleTrackSubscribed)
        .on(RoomEvent.TrackUnsubscribed, handleTrackUnsubscribed)
        .on(RoomEvent.ActiveSpeakersChanged, handleActiveSpeakerChange)
        .on(RoomEvent.Disconnected, handleDisconnect)
        .on(RoomEvent.LocalTrackUnpublished, handleLocalTrackUnpublished);

    // connect to room
    await room.connect(roomUrl, token);
    console.log('connected to room', room.name);

    // publish local camera and mic tracks
    await room.localParticipant.setCameraEnabled(true);
    await room.localParticipant.setMicrophoneEnabled(true);
}

function handleTrackSubscribed(track, publication, participant) {
    if (track.kind === 'video' || track.kind === 'audio') {
        const element = track.attach();
        document.getElementById('video-container').appendChild(element);
    }
}

function handleTrackUnsubscribed(track, publication, participant) {
    track.detach();
}

function handleLocalTrackUnpublished(publication, participant) {
    publication.track.detach();
}

function handleActiveSpeakerChange(speakers) {
    console.log('Active speakers:', speakers);
}

function handleDisconnect() {
    console.log('disconnected from room');
}

window.startLiveKitRoom = startLiveKitRoom;
