<template>
    <div class="inline-block">
        <ButtonDanger @click="isShow = !isShow" v-bind="$attrs">
            <slot />
        </ButtonDanger>

        <Modal :show="isShow" @close="isShow = false">
            <div class="card">

                <div class="card-body">
                    <h3 class="font-bold card-title">
                        Анхаар
                    </h3>
                    <div class="p-3">
                        Та устгахдаа итгэлтэй байна уу?
                    </div>
                </div>
                <div class="justify-end card-footer">
                    <ButtonDanger @click="destroy">Тийм</ButtonDanger>
                    <ButtonPrimary @click="isShow = false">Хаах</ButtonPrimary>
                </div>
            </div>
        </Modal>
    </div>
</template>
<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ButtonDanger from './ButtonDanger.vue';
import Modal from './Modal.vue';
import ButtonPrimary from './ButtonPrimary.vue';

const props = defineProps({
    href: {
        type: [String],
        required: true,
    }
})
const isShow = ref(false);
const destroy = () => {
    router.delete(props.href, { headers: { back: new URLSearchParams(window.location.search).get("callback") } });
}
</script>