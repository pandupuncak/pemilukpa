<template>
    <app-layout v-bind:role="role">
        <template #header>
            <slot name="header"></slot>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <slot name="content"></slot>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './AppLayout'

    export default {
        components: {
            AppLayout,
        },
        props : ['role']
    }
</script>
