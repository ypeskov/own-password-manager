<template>
    <div class="usual-row">
        <div></div>
        <div>
            <button class="button is-primary user-setting-change-button"
                    @click.prevent="changeButtonClicked">{{ trans('app.Change Password') }}
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
                            <label class="label">{{ trans('app.Current password') }}</label>
                        </div>
                        <div class="field-body change-password-field-body">
                            <div class="control change-name-input">
                                <input type="password"
                                       class="input"
                                       v-bind:class="[{'is-danger': isErrorCurrent}]"
                                       @focus="clearErrors('Current')"
                                       v-model="passwordCurrent">
                                <p v-show="isErrorCurrent" class="help is-danger">{{ errorMsgCurrent }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ trans('app.New password') }}</label>
                        </div>
                        <div class="field-body change-password-field-body">
                            <div class="control change-name-input">
                                <input type="password"
                                       class="input"
                                       @focus="clearErrors('New')"
                                       v-model="passwordNew">
                                <p v-show="isErrorNew" class="help is-danger">{{ errorMsgNew }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ trans('app.Confirm password') }}</label>
                        </div>
                        <div class="field-body change-password-field-body">
                            <div class="control change-name-input">
                                <input type="password"
                                       class="input"
                                       @focus="clearErrors('New')"
                                       v-model="passwordConfirm">
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
        name: 'ChangePassword',

        props: [
            'propertyLabel',
            'popupTitle',
        ],

        data() {
            return {
                isActive: false,
                isErrorCurrent: false,
                isErrorNew: false,
                errorMsgCurrent: '',
                errorMsgNew: '',
                passwordCurrent: '',
                passwordNew: '',
                passwordConfirm: '',
            };
        },

        methods: {
            changeButtonClicked: function () {
                this.isActive = true;
                this.passwordCurrent = this.passwordNew = this.passwordConfirm = '';
            },

            close: function () {
                this.isActive = false;
            },

            startChange: function() {
                if (this.passwordNew === '') {
                    this.isErrorNew = true;
                    this.errorMsgNew = Vue.prototype.trans('app.Password must be min 8 characters');
                    return false;
                }

                if (this.passwordNew !== this.passwordConfirm) {
                    this.isErrorNew = true;
                    this.errorMsgNew = Vue.prototype.trans('app.New password and confirm password are different');
                    return false;
                }

                axios.post('/user/settings/password', {
                        passwordCurrent: this.passwordCurrent,
                        passwordNew: this.passwordNew,
                    })
                    .then(response => {
                        const data = response.data;

                        if (response.data.status === 'FAIL') {
                            let errMsg = '';
                            if (Array.isArray(data.message)) {
                                errMsg = data.message.join('<br>');
                            } else {
                                errMsg = data.message;
                            }

                            switch(data.code) {
                                case 'INVALID_CURRENT_PASSWORD':
                                    this.isErrorCurrent = true;
                                    this.errorMsgCurrent = errMsg;
                                    this.passwordCurrent = this.passwordNew = this.passwordConfirm = '';
                                    break;
                                case 'INVALID_NEW_PASSWORD':
                                    this.isErrorNew = true;
                                    this.errorMsgNew = errMsg;
                                    this.passwordCurrent = this.passwordNew = this.passwordConfirm = '';
                                    break;
                                default:
                                    break;
                            }
                        } else {
                            alert(data.message);
                            window.location.reload();
                        }
                    })
                    .catch(error => console.log(error));
            },

            clearErrors: function (type) {
                this[`isError${type}`] = false;
                this[`errorMsg${type}`] = false;
            }
        }
    }
</script>

<style>
    .change-password-field-body {
        flex-grow: 3;
    }
</style>
