<template>
    <authorization-layout v-bind:role="role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight heading">
                Dashboard
            </h2>
        </template>

        <template #content>
            <welcome v-bind:voteStatus="voteStatus" v-bind:isBeforeVotingPeriod="isBeforeVotingPeriod" v-bind:isAfterVotingPeriod="isAfterVotingPeriod"/>
        </template>
    </authorization-layout>
</template>

<script>
    import AuthorizationLayout from './../Layouts/AuthorizationLayout'
    import Welcome from './../Jetstream/Welcome'

    export default {
        components: {
            AuthorizationLayout,
            Welcome,
        },
        props : ['voteStatus', 'role', 'isBeforeVotingPeriod', 'isAfterVotingPeriod']
    }
</script>
