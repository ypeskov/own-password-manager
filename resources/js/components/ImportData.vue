<template>
    <div class="user-settings-content">
        <p>{{ trans('app.Here you can import data from CSV file')+'.' }}</p>

        <hr>

        <div>
            <label class="checkbox">
                <input type="checkbox" v-model:checked="isEncrypted" />
                {{ trans('app.Encrypted') }}
            </label>
        </div>

        <div class="top-spacing-normal">
            <div class="field">
                <div class="control">
                    <div>{{ trans('app.Select method of export') }}:</div>
                    <div class="select is-medium">
                        <select>
                            <option @click.prevent="changeMethod('file')">{{ trans('app.File') }}</option>
                            <option @click.prevent="changeMethod('google-drive')">{{ trans('app.Google Drive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="top-spacing-normal">
            <button @click.prevent="startExport" class="button is-primary">{{ trans('app.Export') }}</button>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ImportData",

        data() {
            return {
                isEncrypted: true,
                exportMethod: 'file',
            };
        },

        methods: {
            startExport: async function() {
                const method = this.exportMethod;

                try {
                    const response = await axios.get(`/export/data/${method}?is_encrypted=${this.isEncrypted ? 1 : 0}`, {
                        responseType: 'blob'
                    });

                    if (method === 'file') {
                        const fileURL = window.URL.createObjectURL(new Blob([response.data]));
                        const fileLink = document.createElement('a');

                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', 'data.csv');

                        document.body.appendChild(fileLink);

                        fileLink.click();
                    }

                    console.log(response);
                } catch (e) {
                    alert('oops in export data');
                }
            },

            changeMethod: function(method) {
                this.exportMethod = method;
            }
        }
    }
</script>

<style scoped>

</style>
