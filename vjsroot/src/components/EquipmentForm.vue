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
        <small>Введите серийные номера через запятую</small>
      </div>
      <div>
        <label for="desc">Примечание:</label>
        <textarea v-model="form.desc" id="desc"></textarea>
      </div>
      <button type="submit">Добавить</button>
      <div v-if="messages.length" class="messages">
        <div v-for="(message, index) in messages" :key="index" class="message">
          {{ message }}
        </div>
      </div>
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
      equipmentTypes: [],
      messages: []
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
      this.messages = [];
      const serialNumbers = this.form.serial_number.split(',').map(sn => sn.trim());
      const equipments = serialNumbers.map(sn => ({
        equipment_type_id: this.form.equipment_type_id,
        serial_number: sn,
        desc: this.form.desc
      }));

      try {
        const response = await axios.post('http://localhost:700/api/equipment', { equipments });
        response.data.results.forEach(result => {
          this.messages.push(result.message);
        });

        if (response.data.results.every(result => result.success)) {
          alert('Все оборудования успешно добавлены!');
          this.form = {
            equipment_type_id: '',
            serial_number: '',
            desc: ''
          };
        }

      } catch (error) {
        this.messages.push('Ошибка при добавлении оборудования');
        console.error('Ошибка при добавлении оборудования:', error);
      }
    }
  }
};
</script>
