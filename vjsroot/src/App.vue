<template>
  <div id="app">
    <nav>
      <router-link to="/">Поиск</router-link>
      <router-link to="/create">Добавить оборудование</router-link>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App'
};
</script>

<style>
nav {
  margin-bottom: 20px;
}
nav a {
  margin-right: 10px;
}
</style>
