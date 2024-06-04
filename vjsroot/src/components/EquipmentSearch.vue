<template>
  <div>
    <h2>Поиск, редактирование и удаление оборудования</h2>
    <div>
      <label for="search">Поиск по серийному номеру или примечанию:</label>
      <input v-model="searchQuery" @input="handleSearch" id="search" type="text" placeholder="Поиск...">
    </div>
    <div v-if="loading">
      <p>Загрузка...</p>
    </div>
    <div v-else-if="searchQuery && equipments.length > 0">
      <div v-for="equipment in equipments" :key="equipment.id">
        <div>
          <label>Тип оборудования:</label>
          <input type="text" :value="equipment.equipment_type_name" disabled>
        </div>
        <div>
          <label>Серийный номер:</label>
          <input type="text" v-model="equipment.serial_number" :disabled="!equipment.isEditing">
        </div>
        <div>
          <label>Примечание:</label>
          <textarea v-model="equipment.desc" :disabled="!equipment.isEditing"></textarea>
        </div>
        <button v-if="!equipment.isEditing" @click="editEquipment(equipment)">Редактировать</button>
        <button v-if="equipment.isEditing" @click="saveEquipment(equipment)">Сохранить</button>
        <button @click="deleteEquipment(equipment.id)">Удалить</button>
      </div>
    </div>
    <div v-else-if="searchQuery">
      <p>Ничего не найдено</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      searchQuery: '',
      equipments: [],
      equipmentTypes: [],
      loading: false
    };
  },
  methods: {
    async handleSearch() {
      if (!this.searchQuery) {
        this.equipments = [];
        return;
      }
      this.loading = true;
      try {
        const response = await axios.get(`http://localhost:700/api/equipment?q=${this.searchQuery}`);
        this.equipments = response.data.data.map(equipment => ({
          ...equipment,
          isEditing: false,
          equipment_type_name: equipment.equipment_type_name || 'Неизвестно'
        }));
      } catch (error) {
        console.error('Ошибка при поиске оборудования:', error);
      } finally {
        this.loading = false;
      }
    },
    editEquipment(equipment) {
      equipment.isEditing = true;
    },
    async saveEquipment(equipment) {
      try {
        await axios.put(`http://localhost:700/api/equipment/${equipment.id}`, equipment);
        equipment.isEditing = false;
      } catch (error) {
        console.error('Ошибка при сохранении оборудования:', error);
      }
    },
    async deleteEquipment(id) {
      try {
        await axios.delete(`http://localhost:700/api/equipment/${id}`);
        this.equipments = this.equipments.filter(equipment => equipment.id !== id);
      } catch (error) {
        console.error('Ошибка при удалении оборудования:', error);
      }
    },
    async loadEquipmentTypes() {
      try {
        const response = await axios.get('http://localhost:700/api/equipment-type');
        this.equipmentTypes = response.data.data;
      } catch (error) {
        console.error('Ошибка при загрузке типов оборудования:', error);
      }
    }
  },
  async mounted() {
    try {
      await this.loadEquipmentTypes();
    } catch (error) {
      console.error('Ошибка при загрузке типов оборудования:', error);
    }
  }
};
</script>
