<template>
  <div class="container">
    <form class="form-horizontal">
      <div class="form-group">
        <label class="col-sm-2 control-label">Nombres:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" v-model="nombre">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Porcentaje:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" v-model="porcentaje">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" @click.prevent="buscarPersonas()">Buscar</button>
        </div>
      </div>
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Departamento</th>
          <th>Localidad</th>
          <th>Municipio</th>
          <th>Años activo</th>
          <th>Tipo persona</th>
          <th>Tipo cargo</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="persona in personas" :key="persona.uuid">
          <td>{{ persona.Nombre_encontrado }}</td>
          <td>{{ persona.departamento }}</td>
          <td>{{ persona.localidad }}</td>
          <td>{{ persona.municipio }}</td>
          <td>{{ persona.años_activo }}</td>
          <td>{{ persona.tipo_persona }}</td>
          <td>{{ persona.tipo_cargo }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'App',
  data() {
    return {
      nombre: '',
      porcentaje: '',
      personas: []
    }
  },
  methods: {
    buscarPersonas() {
      const url = 'http://localhost:8000/api/buscar-persona';
      const params = {
        nombres: this.nombre,
        porcentaje: this.porcentaje
      };

      axios.post(url, { params })
        .then(response => {
          this.personas = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
}
</script>
