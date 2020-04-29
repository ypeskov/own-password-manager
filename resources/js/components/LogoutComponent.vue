<template>
    <form method="POST" action="/logout">
        <input type="hidden" name="_token" :value="csrf">
        <input type="submit" class="button is-primary" :value="trans('app.Logout')" />
    </form>

</template>

<script>
    export default {
        name: 'LogoutComponent',

        props: [
            'csrf',
        ],

        mounted() {

        }
    }
</script>
