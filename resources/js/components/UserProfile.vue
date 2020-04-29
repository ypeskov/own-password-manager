<template>
    <div class="user-settings-content">
        <div class="usual-row">
            <div><strong>{{ trans('app.Date of registration') }}:&nbsp;</strong>{{ user.created_at }}</div>
        </div>

        <change-user-property :property-value="user.name"
                              property-name="name"
                              :property-label="trans('app.New Name')"
                              :popup-title="trans('app.Select your new name')">
        </change-user-property>

        <change-user-property :property-value="user.email"
                              property-name="email"
                              :property-label="trans('app.New Email')"
                              :popup-title="trans('app.Select your new email')">
        </change-user-property>

        <change-password
            popup-title="trans('app.Set up new password')"></change-password>
    </div>
</template>

<script>
    export default {
        name: "UserProfile",

        props: [
            'userSrc',

        ],

        data() {
            return {
                user: {
                    name: '',
                    email: '',
                },
            };
        },

        mounted() {
            this.user = JSON.parse(this.userSrc);
        },


    }
</script>

<style scoped>

</style>
