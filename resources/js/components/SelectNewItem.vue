<template>
    <div id="new-item-select" class="container">
        <div class="field">
            <a v-on:click.prevent="newClicked" class="button is-primary is-fullwidth">{{ trans('app.New') }}</a>
        </div>

        <div v-bind:class="['modal', {'is-active':isActive}]">
            <div class="modal-background"></div>

            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">{{ trans('app.Select type of secure item')}}</p>
                    <button v-on:click.prevent="close" class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="control">
                        <div v-for="type in itemTypes">
                            <label class="radio">
                                <input type="radio"
                                       name="item-type"
                                       v-bind:checked="type.id === selectedTypeId"
                                       @click="newTypeSelected(type.id)">
                                {{ type.name | capitalize }}
                            </label>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" @click.prevent="startCreation">{{ trans('app.Create') }}</button>
                    <button v-on:click.prevent="close" class="button">{{ trans('app.Cancel') }}</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isActive: false,
                itemTypes: [],
                selectedTypeId: 1,
            }
        },

        mounted() {
            axios.get('/data/itemtype')
                .then(response => {
                    this.itemTypes = response.data;
                })
                .catch(error => console.log(error));
        },

        methods: {
            newClicked: function() {
                this.isActive = true;
            },

            close: function () {
                this.isActive = false;
            },

            newTypeSelected: function(typeId) {
                this.selectedTypeId = typeId;
            },

            startCreation: function() {
                window.location.href = `/item/new/${this.selectedTypeId}`;
            }
        }
    }
</script>
