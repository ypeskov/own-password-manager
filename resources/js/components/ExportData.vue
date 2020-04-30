<template>
    <div class="user-settings-content">
        <p>{{ trans('app.Here you can export your data into different targets: File, Google Drive, Dropbox or send by email and messenger')+'.' }}</p>

        <hr>

        <div>
            <label class="checkbox">
                <input type="checkbox" :checked="isEncrypted" />
                {{ trans('app.Import encrypted') }}
            </label>
        </div>

        <div class="top-spacing-normal">
            <button class="button is-primary">{{ trans('app.Export') }}</button>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ExportData",

        data() {
            return {
                isEncrypted: true,
                exportMethod: 'file',
            };
        },

        methods: {
            startExport: function() {

            }
        }
    }
</script>

<style scoped>

</style>
