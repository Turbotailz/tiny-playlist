<template>
    <div class="app container">
        <router-view :user="user" />
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },

    data: () => {
        return {
        }
    },

    computed: {
    },

    mounted() {

    },

    methods: {

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

.app {
  display: flex;
  height: 100%;
  align-items: center;
  justify-content: center;
}
</style>
