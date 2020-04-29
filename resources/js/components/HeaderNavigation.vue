<template>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <h3 class="">
            <a class="navbar-item"
               href="/">{{ trans('app.Own Password Manager') }}
            </a>
        </h3>

        <a role="button"
           v-if="!isGuest"
           @click.prevent="toggleGamburger"
           class="navbar-burger"
           :class="[{'is-active':isActive}]"
           aria-label="menu"
           aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div class="navbar-menu is-active isGuest" v-if="isGuest">
        <div class="navbar-end">
            <div class="buttons-container has-text-right">
                <a class="button is-primary" href="/login">{{ trans('app.Login') }}</a>
                <a class="button has-background-light" href="/register">{{ trans('app.Register') }}</a>
            </div>
        </div>
    </div>

    <div class="navbar-menu" :class="[{'is-active':isActive}]" v-else>
        <div class="navbar-item is-hidden-desktop">
            <a href="/board/password">{{ trans('app.Passwords') }}</a>
        </div>
        <div class="navbar-item is-hidden-desktop">
            <a href="/board/note">{{ trans('app.Notes') }}</a>
        </div>
        <div class="navbar-item is-hidden-desktop">
            <logout-component :csrf="csrf"></logout-component>
        </div>

        <div class="navbar-end is-hidden-touch">
            <div class="buttons-container has-text-right">
                <span>{{ trans('app.Welcome') }},&nbsp;<strong>{{ userName }}</strong></span>
                <logout-component :csrf="csrf"></logout-component>
            </div>
        </div>
    </div>
</nav>
</template>

<script>
    import LogoutComponent from './LogoutComponent';

    export default {
        name: 'HeaderNavigation',

        components: {
            LogoutComponent
        },

        mounted() {
        },

        props: [
            'isGuest',
            'csrf',
            'userName',
        ],

        data: function() {
            return {
                isActive: false,
            };
        },

        methods: {
            toggleGamburger: function(e) {
                this.isActive = !this.isActive;
            }
        }
    }
</script>
