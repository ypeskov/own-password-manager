<template>
    <div>
        <div class="tabs is-toggle">
            <ul>
                <li :class="[(tab === '#profile') ? 'is-active' : '']">
                    <a @click="tabClicked('#profile')">
                        <span>{{ trans('app.Profile') }}</span>
                    </a>
                </li>

                <li :class="[(tab === '#export') ? 'is-active' : '']">
                    <a @click="tabClicked('#export')">
                        <span>{{ trans('app.Export') }}</span>
                    </a>
                </li>

                <li :class="[(tab === '#import') ? 'is-active' : '']">
                    <a @click="tabClicked('#import')">
                        <span>{{ trans('app.Import') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <user-profile v-show="tab === '#profile'" :user-src="user"></user-profile>
        <export-data v-show="tab === '#export'" :user-src="user"></export-data>
        <import-data v-show="tab === '#import'" :user-src="user"></import-data>
    </div>
</template>

<script>
    import UserProfile from "./UserProfile";
    import ExportData from "./ExportData";
    import ImportData from "./ImportData";

    const availableTabs = [
        '#profile',
        '#export',
        '#import',
    ];

    export default {
        name: "SettingsContainer",
        components: {ImportData, ExportData, UserProfile},
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
