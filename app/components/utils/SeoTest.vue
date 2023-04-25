<template>
    <span v-if="false" />
</template>

<script>
export default {
    props: {
        title: String
    },
    head() {
        return {
            title: this.title
        }
    },
}
</script>