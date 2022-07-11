<template>
  <q-card style="width: 20rem" class="text-grey-9">
    <q-card-section>
      <div class="text-h6 text-center">{{ $props.camera.title }}</div>

      <q-chip
        class="glossy text-white"
        :icon="$props.camera.works ? 'mdi-video' : 'mdi-video-off'"
        :color="$props.camera.works ? 'positive' : 'negative'"
        :label="$props.camera.works ? 'Ok' : 'Error'"
      />
      <q-chip class="glossy" :label="$props.camera.ip" />
      <q-chip
        class="glossy"
        :label="`${$props.camera.brand} ${$props.camera.model}`"
      />
      <q-chip class="glossy" :label="$props.camera.dome ? 'DOMO' : 'FIJA'" />
    </q-card-section>
    <q-card-section v-if="$props.camera.comments">
      <p class="text-justify">
        {{ $props.camera.comments }}
      </p>
    </q-card-section>
    <q-card-actions>
      <q-btn
        color="primary"
        icon="mdi-pencil"
        dense
        label="Editar"
        outline
        @click="onEdit"
      /><q-btn
        color="primary"
        icon="mdi-cube"
        dense
        label="Abrir"
        outline
        @click="openCamera(($props.camera as ICamera).ip)"
      />
    </q-card-actions>
  </q-card>
</template>

<script setup lang="ts">
import { openURL, useQuasar } from 'quasar';
import { ICamera } from 'src/types';

const $emit = defineEmits<{
  (e: 'edit', p: ICamera): void;
}>();
const $props = defineProps<{ camera: ICamera }>();
const $q = useQuasar();

/**
 * Open Camera
 * @param ip
 */
function openCamera(ip: string) {
  openURL(`http://${ip}`);
}

function onEdit() {
  $q.dialog({
    title: 'Editar Camara',
    message: 'Desea editar la camara?',
  }).onOk(() => {
    $emit('edit', $props.camera);
  });
}
</script>
