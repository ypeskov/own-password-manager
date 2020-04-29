<template>
    <div>
        <div class="tabs is-toggle">
            <ul>
                <li :class="[(currentTab === 'profile') ? 'is-active' : '']">
                    <a @click="tabClicked('profile')">
                        <span>{{ trans('app.Profile') }}</span>
                    </a>
                </li>

                <li :class="[(currentTab === 'export') ? 'is-active' : '']">
                    <a @click="tabClicked('export')">
                        <span>{{ trans('app.Export') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <user-profile v-show="currentTab === 'profile'" :user-src="user"></user-profile>
        <export-data v-show="currentTab === 'export'" :user-src="user"></export-data>
    </div>
</template>

<script>
    import UserProfile from "./UserProfile";
    import ExportData from "./ExportData";
    export default {
        name: "SettingsContainer",
        components: {ExportData, UserProfile},
        props: [
            'user'
        ],

        data() {
            return {
                currentTab: 'profile',
            };
        },

        methods: {
            tabClicked: function(newTab) {
                this.currentTab = newTab;
            }
        }
    }
</script>

<style scoped>

</style>
