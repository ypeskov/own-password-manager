<template>
    <div>
        <div class="has-text-right">
            <a @click.prevent="clicked" class="button is-danger">{{ trans('app.Delete') }}</a>
        </div>
        <div v-bind:class="['modal', {'is-active':isActive}]">
            <div class="modal-background"></div>

            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">{{ trans('app.Are you sure you want to delete this item?')}}</p>
                    <button v-on:click.prevent="close" class="delete" aria-label="close"></button>
                </header>
                <footer class="modal-card-foot">
                    <a v-bind:href="deleteUrl" class="button is-danger">{{ trans('app.Yes') }}</a>
                    <button v-on:click.prevent="close" class="button">{{ trans('app.Cancel') }}</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DeleteItem",

        mounted() {
        },

        props: [
            'itemId',
        ],

        data: function() {
            return {
                isActive: false,
            };
        },

        computed: {
            deleteUrl: function () {
                return `/item/delete/${this.itemId}`;
            }
        },

        methods: {
            clicked: function() {
                this.isActive = true;
            },

            close: function() {
                this.isActive = false;
            }
        }
    }
</script>

<style scoped>

</style>
