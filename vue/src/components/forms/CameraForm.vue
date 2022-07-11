<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section class="q-gutter-y-sm">
        <q-input v-model="form.title" required type="text" label="Nombre" />
        <q-input v-model="form.ip" required type="text" label="IP" />
        <q-select
          v-model="form.brand"
          :options="['AXIS', 'PANASONIC', 'HUAWEI']"
          label="Marca"
        />
        <q-input v-model="form.model" type="text" label="Modelo" />
        <div class="row q-col-gutter-sm">
          <div class="col-xs-6">
            <q-toggle
              v-model="form.works"
              :color="form.works ? 'positive' : 'negative'"
              :label="form.works ? 'Funciona' : 'No Funciona'"
            />
          </div>
          <div class="col-xs-6">
            <q-toggle
              v-model="form.dome"
              :color="form.dome ? 'positive' : 'negative'"
              :label="form.dome ? 'DOMO' : 'FIJA'"
            />
          </div>
        </div>
        <q-input
          v-model="form.comments"
          type="textarea"
          label="Observaciones"
        />
      </q-card-section>
      <q-card-actions>
        <q-btn
          color="primary"
          outline
          label="Cancel"
          @click="$emit('canceled')"
        />
        <q-btn
          color="negative"
          label="Eliminar"
          @click="onDestroy"
          v-if="$props.update"
        />
        <q-btn color="primary" label="Guardar" type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { LatLng, latLng } from 'leaflet';
import { useQuasar } from 'quasar';
import { $api } from 'src/boot/axios';
import { $notificationHelper } from 'src/helpers';
import { ICamera } from 'src/types';
import { onBeforeMount, ref } from 'vue';
/**
 * -----------------------------------------
 *	Injects
 * -----------------------------------------
 */
const $emit = defineEmits<{
  (e: 'completed', p: ICamera): void;
  (e: 'canceled'): void;
  (e: 'destroy', p: ICamera): void;
}>();
const $props = defineProps<{ position: LatLng; update?: ICamera }>();
const $q = useQuasar();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const form = ref<ICamera>({
  brand: 'AXIS',
  dome: false,
  id: 0,
  ip: '106.41.31.1',
  position: latLng(0, 0),
  title: 'Camara',
  works: true,
  comments: '',
  model: '',
});
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * onDestroy
 */
async function onDestroy() {
  $q.dialog({
    title: 'Eliminar Camara',
    message: 'Desea eliminar la camara?',
  }).onOk(async () => {
    if ($props.update) {
      $notificationHelper.loading();
      try {
        await $api.delete(`api/cameras/${$props.update.id}`);
        $emit('destroy', $props.update);
      } catch (error) {
        $notificationHelper.axiosError(error);
      }
      $notificationHelper.loading(false);
    }
  });
}
/**
 * onSubmit
 */
async function onSubmit() {
  $notificationHelper.loading();
  try {
    if ($props.update) {
      $emit(
        'completed',
        (
          await $api.patch<ICamera>(
            `api/cameras/${$props.update.id}`,
            form.value
          )
        ).data
      );
    } else {
      $emit(
        'completed',
        (await $api.post<ICamera>('api/cameras', form.value)).data
      );
    }
  } catch (error) {
    $notificationHelper.axiosError(error);
  }
  $notificationHelper.loading(false);
}

onBeforeMount(() => {
  if ($props.update) {
    form.value = $props.update;
  } else {
    form.value.position = $props.position;
  }
});
</script>
