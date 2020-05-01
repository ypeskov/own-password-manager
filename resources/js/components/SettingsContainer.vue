<template>
    <div>
        <div class="tabs is-toggle">
            <ul>
                <li :class="[(tab === '#profile') ? 'is-active' : '']">
                    <a @click="tabClicked('profile')">
                        <span>{{ trans('app.Profile') }}</span>
                    </a>
                </li>

                <li :class="[(tab === '#export') ? 'is-active' : '']">
                    <a @click="tabClicked('export')">
                        <span>{{ trans('app.Export') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <user-profile v-show="tab === '#profile'" :user-src="user"></user-profile>
        <export-data v-show="tab === '#export'" :user-src="user"></export-data>
    </div>
</template>

<script>
    import UserProfile from "./UserProfile";
    import ExportData from "./ExportData";

    const availableTabs = [
        '#profile',
        '#export',
    ];

    export default {
        name: "SettingsContainer",
        components: {ExportData, UserProfile},
        props: [
            'user',
        ],

        data() {
            return {
                tab: '',
            };
        },

        mounted() {
            const tab = window.location.hash;

            if (availableTabs.includes(tab)) {
                this.tab = tab;
            } else {
                this.tab = '#profile';
            }
        },

        methods: {
            tabClicked: function(newTab) {
                this.tab = newTab;
                window.location.hash = newTab;
            }
        }
    }
</script>

<style scoped>

</style>
