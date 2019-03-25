<template>
    <ul id="playlists">
        <li v-if="playlists.length == 0" class="no-playlists">
            You have no playlists :(
        </li>

        <router-link :to="'/playlist/' + playlist.id" tag="li" class="playlist" v-for="playlist in playlists" :key="playlist.id">
            <div class="background">
                <img v-for="art in playlist.artwork" :src="art">
            </div>
            <div class="overlay">
                {{ playlist.name }}
            </div>
            <i v-if="playlist.public" class="fal fa-globe-asia"></i>
            <div @click.stop="deletePlaylist(playlist)" class="delete">
                <i class="fal fa-times-square"></i>
            </div>
        </router-link>

        <li class="create" @click="creating = !creating">
            <div class="creating" v-if="creating" @click.stop>
                <span>Name:</span>
                <input type="text" v-model="create.name" autofocus>
                <button @click="createPlaylist">Add</button>
            </div>
            <div v-else>
                <i class="fal fa-plus"></i>
                Add playlist
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        user: Object,
    },

    data: () => {
        return {
            userAuth: {},
            creating: false,
            create: {
                name: '',
                public: false,
            }
        }
    },

    computed: {
        playlists: function() {
            if (this.userAuth.playlists) {
                return this.userAuth.playlists;
            } else {
                return [];
            }
        }
    },

    mounted() {
        this.getPlaylists();
    },

    methods: {
        getPlaylists: function() {
            axios.get('/api/user/', {
                params: {
                    'api_token': this.user.token,
                }
            })
            .then((res) => {
                this.userAuth = res.data.user;
            })
            .catch((error) => {
                console.error(error);
            });
        },

        createPlaylist: function() {
            axios.post('/api/playlist', {
                'api_token': this.user.token,
                'user_id': this.userAuth.id,
                name: this.create.name,
                public: this.create.public,
            })
            .then((res) => {
                this.userAuth.playlists.push(res.data);
                this.creating = false;
                this.create = {
                    name: '',
                    public: false,
                }
            })
            .catch((error) => {
                console.error(error);
            });
        },

        deletePlaylist: function(playlist) {
            axios.delete('/api/playlist/' + playlist.id, {
                params: {
                    'api_token': this.user.token,
                },
            })
            .then((res) => {
                this.getPlaylists();
            })
            .catch((error) => {
                console.error(error);
            });
        },
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

#playlists {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    align-items: center;
    justify-content: center;
    list-style: none;
    margin: 0;
    padding: 0;

    > li {
        width: 200px;
        height: 200px;

        &.no-playlists {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2em;
            text-align: center;
        }

        &.playlist {
            background: rgba(255,255,255,.2);
            margin: 1em;
            box-shadow: 0 0 32px rgba(0,0,0,.1);
            display: flex;
            position: relative;
            cursor: pointer;

            .background {
                display: flex;
                flex-wrap: wrap;
                position: relative;
                z-index: 1;

                img {
                    width: 50%;
                    height: 50%;
                }
            }

            .overlay {
                position: absolute;
                top: 0;
                bottom: 0;
                width: 100%;
                background: rgba(0,0,0,.5);
                padding: 1em;
                display: flex;
                align-items: center;
                justify-content: center;
                color: $primary;
                font-size: 1.5em;
                text-align: center;
                z-index: 2;
                transition: background .3s;
            }

            &:hover {
                .overlay {
                    background: rgba(0,0,0,.75);
                }

                .delete {
                    opacity: 1;
                }
            }
        }

        &.create {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: $primary;
            font-size: 1.5em;
            transition: background .3s;
            cursor: pointer;

            > div {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            svg {
                font-size: 4em;
            }

            &:hover {
                background: rgba(0,0,0,.1);
            }

            .creating {
                height: 100%;
                background: rgba(0,0,0,.1);

                span {
                    color: #EEE;
                    font-size: 1rem;
                }

                input {
                    font: inherit;
                    width: 100%;
                    background: transparent;
                    color: $primary;
                    border: 0;
                    padding: .5em 1em;
                    text-align: center;
                    outline: none;
                }

                button {
                    font: inherit;
                    background: $primary;
                    color: $secondary;
                    font-size: 1rem;
                    border: 0;
                }
            }

        }

        .fa-globe-asia {
            position: absolute;
            bottom: .5em;
            right: .5em;
            color: $primary;
            z-index: 3;
        }

        .delete {
            opacity: 0;
            transition: opacity .3s;
            position: absolute;
            top: .5em;
            right: .5em;
            color: $primary;
            z-index: 3;
        }
    }
}
</style>
