<template>
    <div class="container mt-3">
      <div class="card">
        <div class="card-header">
          <h4>Buscar Persona</h4>
        </div>
        <div class="card-body">
          <form @submit.prevent="buscarPersona">
            <div class="form-group">
              <label for="nombre">Nombres:</label>
              <input type="text" class="form-control" id="nombre" v-model="nombre" required>
            </div>
            <div class="form-group">
              <label for="porcentaje">Porcentaje:</label>
              <input type="number" class="form-control" id="porcentaje" v-model="porcentaje" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
          </form>
          <div v-if="personas">
            <hr>
            <h5>Resultados:</h5>
            <div v-for="(persona, index) in personas" :key="index">
              <h6>Persona {{ index + 1 }}</h6>
              <p>Nombre: {{ persona.nombre }}</p>
              <p>Porcentaje de coincidencia: {{ persona.porcentaje }}%</p>
            </div>
          </div>
          <div v-if="error">
            <hr>
            <div class="alert alert-danger" role="alert">
              {{ error }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'BuscarPersona',
    data() {
      return {
        nombre: '',
        porcentaje: '',
        personas: null,
        error: null,
      };
    },
    methods: {
      buscarPersona() {
        axios.post('http://localhost:8000/api/buscar-persona', {
          nombre: this.nombre,
          porcentaje: this.porcentaje,
        })
        .then(response => {
          this.personas = response.data;
          this.error = null;
        })
        .catch(error => {
          this.personas = null;
          this.error = error.response.data.message;
        });
      }
    }
  };
  </script>
  