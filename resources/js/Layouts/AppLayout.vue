<template>
    <div id="mylayout" class="min-h-screen bg-gray-100">
        <vue-confirm-dialog class="vue-confirm"></vue-confirm-dialog>
        <nav class="bg-white border-gray-100 my-content border-b-4 border-green-500">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-24">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <inertia-link :href="route('dashboard')">
                                <jet-application-mark class="block h-24 w-auto" />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 lg:flex">
                            <jet-nav-link :href="route('dashboard')" :active="$page.currentRouteName == 'dashboard'">
                                Dashboard
                            </jet-nav-link>

                            <!-- Admin Only -->
                            <jet-nav-link v-if="role === 1 || role === 2" :href="route('vote.voters')" :active="$page.currentRouteName == 'vote.voters'">
                                Daftar Pemilih
                            </jet-nav-link>
                            <jet-nav-link v-if="role === 1 || role === 2" :href="route('vote.results')" :active="$page.currentRouteName == 'vote.results'">
                                Hasil Pemilu
                            </jet-nav-link>

                            <!-- Superadmin Only -->
                            <jet-nav-link v-if="role === 1" :href="route('vote.requests')" :active="$page.currentRouteName == 'vote.requests'">
                                Daftar Votes
                            </jet-nav-link>
                            <jet-nav-link v-if="role === 1" :href="route('users')" :active="$page.currentRouteName == 'users'">
                                User Management
                            </jet-nav-link>
                        </div>

                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden lg:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{$page.user.nim + ' ' + $page.user.name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </template>

                                <template #content>
                                    <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.jetstream.hasApiFeatures">
                                        API Tokens
                                    </jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Logout
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center lg:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="lg:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <jet-responsive-nav-link :href="route('dashboard')" :active="$page.currentRouteName == 'dashboard'">
                        Dashboard
                    </jet-responsive-nav-link>

                    <!-- Admin only -->
                    <jet-responsive-nav-link v-if="role === 1 || role === 2" :href="route('vote.voters')" :active="$page.currentRouteName == 'vote.voters'">
                        Daftar Pemilih
                    </jet-responsive-nav-link>

                    <jet-responsive-nav-link v-if="role === 1 || role === 2" :href="route('vote.results')" :active="$page.currentRouteName == 'vote.results'">
                        Hasil Pemilu
                    </jet-responsive-nav-link>

                    <!-- Superadmin only -->
                    <jet-responsive-nav-link v-if="role === 1" :href="route('vote.requests')" :active="$page.currentRouteName == 'vote.requests'">
                        Daftar Votes
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link v-if="role === 1" :href="route('users')" :active="$page.currentRouteName == 'users'">
                        User Management
                    </jet-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">{{ $page.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.user.email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <jet-responsive-nav-link :href="route('api-tokens.index')" :active="$page.currentRouteName == 'api-tokens.index'" v-if="$page.jetstream.hasApiFeatures">
                            API Tokens
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                Logout
                            </jet-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->


        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>

        <!-- Widgets -->
        <!-- <div id="low-el" class="text-center">
            <img  src="/img/low-el2.png" alt="low" class="mx-auto" />
        </div> -->
    </div>
</template>

<script>
    import JetApplicationLogo from './../Jetstream/ApplicationLogo'
    import JetApplicationMark from './../Jetstream/ApplicationMark'
    import JetDropdown from './../Jetstream/Dropdown'
    import JetDropdownLink from './../Jetstream/DropdownLink'
    import JetNavLink from './../Jetstream/NavLink'
    import JetResponsiveNavLink from './../Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetApplicationLogo,
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        props : ['role'],

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },
        },

        computed: {
            path() {
                return window.location.pathname
            }
        }
    }
</script>

<style>
    /* Global styles */
    @import url('https://fonts.googleapis.com/css2?family=Livvic:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,400&display=swap');

    @font-face {
        font-family: 'Florencesans';
        src: url('/fonts/Florencesans/Florsn01.ttf');
    }

    .heading {
        font-family: 'Florencesans', sans-serif;
        text-transform: uppercase;
    }

    .my-content {
        font-family: 'Livvic', sans-serif;
    }
</style>

<style scoped>
    #mylayout {
        background-color: #f8fafc;
    }

    main {
        position: relative;
        z-index: 2;
    }

    #low-el {
        width: 100vw;
        position: fixed;
        bottom: 0;
        z-index: 0;
    }

    #low-el img {
        width: 100vw;
    }
</style>
