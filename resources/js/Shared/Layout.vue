<script setup>
import Navbar from '@/Shared/Navbar.vue';
import FlashMessage from '@/Shared/FlashMessage.vue';
</script>

<template>
    <div>
        <Navbar />
        <main>
            <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 sm:px-0">
                    <div class="flex flex-col items-center">
                        <div class="sm:mx-0.5 lg:mx-0.5">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8"></div>
                            <FlashMessage
                                v-if="$page.props.flash.success || $page.props.flash.error"
                                :flash="$page.props.flash"
                            />
                            <slot />
                        </div>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>
</template>
