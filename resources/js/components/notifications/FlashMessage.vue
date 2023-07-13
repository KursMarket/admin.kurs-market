<template>
    <notifications
        :position="position"
        :width="350"
        :duration="duration"
        :speed="speed"
    >
    </notifications>
</template>

<script>
    export default {
        name: "FlashMessage",
        props: {
            position: {
                type: String,
                required: false,
                default: 'top right'
            },
            duration: {
                type: Number,
                required: false,
                default: -1
            },
            speed: {
                type: Number,
                required: false,
                default: 300
            }
        },
    }
</script>

<style scoped>

</style>
