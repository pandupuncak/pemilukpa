<template>
    <div>
        <h1>Vue Router Pemilu KPA App</h1>
        <p>
            <router-link :to="{ name: 'Dashboard' }">Dashboard</router-link> |
            <router-link :to="{ name: 'Users' }">Users</router-link>
            <router-link :to="{ name: 'Vote' }">Voting</router-link> |
            <router-link :to="{ name: 'Voters' }">Voters</router-link>
            <router-link :to="{ name: 'VoteRequests' }">Vote Filled</router-link> |
            <router-link :to="{ name: 'VoteResult' }">Voting Results</router-link>
        </p>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>