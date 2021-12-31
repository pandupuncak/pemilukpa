<template>
    <authorization-layout v-bind:role="role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Formulir Pemilu
            </h2>
        </template>

        <template #content>
            <div>
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200 my-content">
                    <div class="text-2xl">
                        Gunakan Hak Suara Anda
                    </div>
                    <br/>

                    <irv-vote-form v-if="isIRV" />
                    <normal-vote-form v-else />
                </div>
            </div>
        </template>
    </authorization-layout>
</template>

<script>
    import AuthorizationLayout from './../../Layouts/AuthorizationLayout'
    import IrvVoteForm from './IrvVoteForm'
    import NormalVoteForm from './NormalVoteForm'

    export default {
        components: {
            AuthorizationLayout,
            NormalVoteForm,
            IrvVoteForm,
        },
        data() {
            return {
                isIRV: false,
            }
        },
        props : ['role']
    }
</script>
