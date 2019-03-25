<template>
    <div id="playlist">
        <div class="col playlist-songs">
            <h1>{{ playlist.name }}</h1>
            <p>Song list</p>
            <ul class="song-list">
                <li v-for="(song, index) in playlist.songs" :key="index + '_' + song.id">
                    <img :src="song.art_medium" :alt="`${song.name} by ${song.artist}`">
                    <div class="details">
                        <span>{{ song.name }}</span>
                        <span>{{ song.artist }}</span>
                    </div>
                    <div class="delete" @click="deleteSong(song)">
                        <i class="fal fa-times-square"></i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col add-song">
            <h2>Add a song</h2>
            <div class="form-group">
                <input class="form-control" type="text" v-model="search.name" @keydown.enter="searchSong">
                <button class="btn btn-primary" @click="searchSong">Search</button>
            </div>
            <ul class="song-list">
                <li v-for="(song, index) in search.results" :key="index + '_' + song.mbid" @click="addSong(song)">
                    <img :src="song.image[1]['#text']" :alt="`${song.name} by ${song.artist}`">
                    <div class="details">
                        <span>{{ song.name }}</span>
                        <span>{{ song.artist }}</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },

    data: () => {
        return {
            playlist: {},
            search: {
                name: '',
                results: [],
            }
        }
    },

    computed: {

    },

    mounted() {
        this.getPlaylist(this.$route.params.playlistId);
    },

    methods: {
        getPlaylist: function(id) {
            axios.get('/api/playlist/' + id, {
                params: {
                    'api_token': this.user.token,
                }
            })
            .then((res) => {
                this.playlist = res.data;
            })
            .catch((error) => {
                console.error(error);
            });
        },

        searchSong: function() {
            axios.get('http://ws.audioscrobbler.com/2.0/', {
                params: {
                    method: 'track.search',
                    track: this.search.name,
                    api_key: '87b51db7741ca882c87ba5d13b3ce64c',
                    format: 'json',
                    limit: 10,
                }
            })
            .then((res) => {
                this.search.results = res.data.results.trackmatches.track;
            })
            .catch((error) => {
                console.error(error);
            });
        },

        addSong: function(song) {
            axios.post('/api/playlist/' + this.playlist.id + '/song', {
                'api_token': this.user.token,
                name: song.name,
                artist: song.artist,
                mbid: song.mbid,
                url: song.url,
                'art_small': song.image[0]['#text'],
                'art_medium': song.image[1]['#text'],
                'art_large': song.image[2]['#text'],
                'art_extralarge': song.image[3]['#text'],
            })
            .then((res) => {
                this.playlist = res.data;
            })
            .catch((error) => {
                console.error(error);
            });
        },

        deleteSong: function(song) {
            axios.delete('/api/playlist/' + this.playlist.id + '/song/' + song.id, {
                params: {
                    'api_token': this.user.token,
                }
            })
            .then((res) => {
                this.playlist = res.data;
            })
            .catch((error) => {
                console.error(error);
            });
        },

        // createPlaylist: function() {
        //     axios.post('/api/playlist', {
        //         'api_token': this.user.token,
        //         'user_id': this.userAuth.id,
        //         name: this.create.name,
        //         public: this.create.public,
        //     })
        //     .then((res) => {
        //         this.userAuth.playlists.push(res.data);
        //         this.creating = false;
        //         this.create = {
        //             name: '',
        //             public: false,
        //         }
        //     })
        //     .catch((error) => {
        //         console.error(error);
        //     });
        // },

        // deletePlaylist: function(playlist) {
        //     axios.delete('/api/playlist/' + playlist.id, {
        //         params: {
        //             'api_token': this.user.token,
        //         },
        //     })
        //     .then((res) => {
        //         this.getPlaylists();
        //     })
        //     .catch((error) => {
        //         console.error(error);
        //     });
        // },
    }
}
</script>

<style lang="scss">
// Colors
$primary: #F9F845;
$primary2: #E4E328;
$primary3: #C1C006;
$primary4: #9E9D05;

$secondary: #03395D;
$secondary2: #0E4A6D;
$secondary3: #266786;
$secondary4: #408DA8;

#playlist {
    width: 64em;
    display: flex;
    height: 80vh;

    .playlist-songs {
        padding: 1em;
        display: flex;
        flex-direction: column;

        h1 {
            font-family: Nunito;
            color: $primary;
            font-weight: 800;
        }

        .delete {
            position: absolute;
            right: 1em;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            color: $primary;
        }

        li {
            position: relative;
            &:hover {
                .delete {
                    opacity: 1;
                }
            }
        }
    }

    .add-song {
        background: rgba(0,0,0,.2);
        border-radius: 4px;
        padding: 1em;
        display: flex;
        flex-direction: column;

        .form-group {
            display: flex;

            input {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            button {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        }
    }

    .song-list {
        list-style: none;
        margin: 0;
        padding: 0;
        flex: 1 1 auto;
        overflow-y: auto;

        li {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
            cursor: pointer;

            &:hover {
                background: rgba(0,0,0,.2);
            }

            img {
                flex: 0 0 auto;
                margin-right: 1em;
            }

            .details {
                display: flex;
                flex-direction: column;

                span {
                    &:last-child {
                        opacity: .66;
                    }
                }
            }
        }
    }
}
</style>
