<template>
    <div class="usual-row">
        <div><strong>{{ trans('app.Name') }}</strong>:&nbsp;{{ propertyValue }}</div>

        <div>
            <button class="button is-primary user-setting-change-button"
                    @click.prevent="changeButtonClicked">{{ trans('app.Change') }}
            </button>
        </div>

        <div v-bind:class="['modal', {'is-active':isActive}]">
            <div class="modal-background"></div>

            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">{{ popupTitle }}</p>
                    <button v-on:click.prevent="close" class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ propertyLabel }}</label>
                        </div>
                        <div class="field-body">
                            <div class="control change-name-input">
                                <input type="input"
                                       class="input"
                                       v-model:value="currentValue">
                                <p v-show="isError" class="help is-danger">{{ errorMsg }}</p>
                            </div>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" @click.prevent="startChange">{{ trans('app.Change') }}</button>
                    <button v-on:click.prevent="close" class="button">{{ trans('app.Cancel') }}</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ChangeNameComponent',

        props: [
            'propertyValue',
            'propertyName',
            'popupTitle',
            'propertyLabel',
        ],

        data() {
            return {
                isInitial: true,
                isActive: false,
                isError: false,
                currentValue: '',
                errorMsg: '',
            };
        },

        updated() {
            if (this.isInitial) {
                this.currentValue = this.propertyValue;
                this.isInitial = false;
            }
        },

        methods: {
            changeButtonClicked: function() {
                this.isActive = true;
            },

            close: function () {
                this.isActive = false;
            },

            startChange: function() {
                if (this.currentValue.length === 0) {
                    this.errorMsg = Vue.prototype.trans('app.This field is required');
                    this.isError = true;
                    return false;
                }

                axios
                    .post(`/user/settings/${this.propertyName}/`, {
                        value: this.currentValue
                    })
                    .then(response => {
                        if (response.data.status === 'OK') {
                            window.location.reload()
                        } else {
                            this.errorMsg = response.data.message.join('<br>');
                            this.isError = true;
                        }
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>

<style>
    .change-name-input {
        width: 100%;
    }
</style>
