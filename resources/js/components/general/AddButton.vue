<template>
    <a
        :href="url"
        :class="`btn mb-3 ${classes}`"
        @click.prevent="navigateToUrl"
    >
        <img src="/assets/img/icons/bi_plus-circle-fill.png" class="me-2" alt="">
        Добавить
    </a>
</template>

<script>
export default {
    name: "AddButton",
    props: {
        url: {
            type: String,
            required: true
        },
        classes: {
            type: String,
            required: false,
            default: ''
        }
    },
    methods: {
        navigateToUrl() {
            window.location.href = this.url
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
