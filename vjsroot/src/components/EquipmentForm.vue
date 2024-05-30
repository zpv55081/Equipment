<template>
  <div>
    <h2>Добавить оборудование</h2>
    <form @submit.prevent="handleSubmit">
      <div>
        <label for="equipmentType">Тип оборудования:</label>
        <select v-model="form.equipment_type_id" id="equipmentType" required>
          <option v-for="type in equipmentTypes" :key="type.id" :value="type.id">
            {{ type.name }}
          </option>
        </select>
      </div>
      <div>
        <label for="serialNumber">Серийные номера:</label>
        <textarea v-model="form.serial_number" id="serialNumber" required></textarea>
      </div>
      <div>
        <label for="desc">Примечание:</label>
        <textarea v-model="form.desc" id="desc"></textarea>
      </div>
      <button type="submit">Добавить</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        equipment_type_id: '',
        serial_number: '',
        desc: ''
      },
      equipmentTypes: []
    };
  },
  created() {
    this.fetchEquipmentTypes();
  },
  methods: {
    async fetchEquipmentTypes() {
      try {
        const response = await axios.get('http://localhost:700/api/equipment-type');
        this.equipmentTypes = response.data.data;
      } catch (error) {
        console.error('Ошибка при загрузке типов оборудования:', error);
      }
    },
    async handleSubmit() {
      try {
        await axios.post('http://localhost:700/api/equipment', this.form);
        alert('Оборудование успешно добавлено!');
        this.form = {
          equipment_type_id: '',
          serial_number: '',
          desc: ''
        };
      } catch (error) {
        console.error('Ошибка при добавлении оборудования:', error);
      }
    }
  }
};
</script>
