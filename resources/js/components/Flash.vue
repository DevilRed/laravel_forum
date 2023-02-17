<template>
    <div class="alert alert-warning alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>

</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: "",
                show: false
            }
        },
        mounted() {
            // console.log(this.message)
        },
        created() {
            if (this.message) {
                this.body = this.message;
                this.show = true;
            }
        }
    }
</script>

<style>
.alert-flash {
    position: fixed;
    right: 25px;
    top: 25px;
    z-index: 1;
}
</style>
