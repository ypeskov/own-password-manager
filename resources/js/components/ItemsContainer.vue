<template>
    <div class="box content-container">
        <div class="columns is-hidden-touch">
            <div class="column is-one-fifth"></div>
            <div class="column is-uppercase has-text-weight-bold">{{ trans('app.Name') }}</div>
            <div class="column is-one-fifth is-uppercase has-text-weight-bold">{{ trans('app.Last Updated') }}</div>
            <div class="column is-one-fifth is-uppercase has-text-weight-bold"></div>
        </div>

        <div v-if="items.length > 0">
            <div v-for="(item, index) in items">
                <div class="columns" v-show="getFolder(item, index)">
                    <div class="column item-folder">
                        <a @click.prevent="swapFolderView(item.folder)">
                            {{ getFolder(item, index) }}
                            <span v-show="item.show"><i class="fas fa-minus-circle"></i></span>
                            <span v-show="item.show === false"><i class="fas fa-plus-circle"></i></span>
                        </a>
                    </div>
                </div>

                <div class="columns item-container is-vcentered" v-show="item.show">
                    <div class="column is-one-fifth">
                        <a :href="viewLink(item)" class="button is-primary is-fullwidth">{{ trans('app.View') }}</a>
                    </div>

                    <div class="column item-name-val">{{ item.name }}</div>
                    <div class="column is-one-fifth item-updated-val">{{ item.updated_at }}</div>
                    <div class="column is-one-fifth">
                        <delete-item :item-id=item.id></delete-item>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>{{ trans('app.No results') }}</div>

    </div>
</template>

<script>
    export default {
        name: "ItemsContainer",

        props: [
            'itemsSrc',
        ],

        methods: {
            getFolder: function(item, index) {
                if (index === 0 || index > 0 && item.folder !== this.items[index-1].folder) {
                    return item.folder;
                } else {
                    return null;
                }
            },

            swapFolderView: function(folder) {
                this.items = this.items.map(val => {
                    if (val.folder === folder) {
                        val.show = !val.show;
                    }

                    return val;
                });
            },

            viewLink: function(item) {
                return `/item/view/${item.id}`;
            }
        },

        computed: {

        },

        data: function() {
            return {
                items: [],
                initialFolder: '',
                foldersState: {},
            };
        },

        mounted: function () {
            this.items = JSON.parse(this.itemsSrc);
            if (this.items.length > 0) {
                this.initialFolder = this.items[0].folder;
            }

        }
    }
</script>

<style scoped lang="scss">

</style>
