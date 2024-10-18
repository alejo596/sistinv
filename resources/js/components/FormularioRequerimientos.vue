<template>
  <div class="card">
    <div class="card-body">
      <h2 class="card-title mb-4">Formulario de Requerimientos</h2>
      <form @submit.prevent="guardarRequerimiento">
        <div class="row g-3">
          <div class="col-md-12">
            <div class="form-floating">
              <textarea
              id="requerimiento"
              v-model="requerimiento.descripcion"
              class="form-control"
              placeholder="Ingrese el requerimiento"
              style="height: 100px"
              ></textarea>
              <label for="requerimiento">Requerimiento</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <select id="unidad" v-model="requerimiento.unidad" class="form-select">
                <option v-for="unidad in unidades" :key="unidad.id" :value="unidad.nombre">
                  {{ unidad.nombre }}
                </option>
              </select>
              <label for="unidad">Unidad</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input
              type="text"
              id="usuario"
              v-model="requerimiento.usuario"
              class="form-control"
              placeholder="Ingrese el usuario solicitante"
              >
              <label for="usuario">Usuario Solicitante</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input
              type="number"
              id="anio"
              v-model="requerimiento.anio"
              class="form-control"
              placeholder="Año"
              >
              <label for="anio">Año</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <select
              id="mes"
              v-model="requerimiento.mes"
              class="form-select"
              >
              <option v-for="(mes, index) in meses" :key="index" :value="index + 1">
                {{ mes }}
              </option>
            </select>
            <label for="mes">Mes</label>
          </div>
        </div>
        <div class="col-12 text-center mt-4">
          <button type="submit" class="btn btn-gradient">Guardar Requerimiento</button>
        </div>
      </div>
    </form>
  </div>
  <div class="pt-3">
    <div class="card">
      <div class="card-body">
      
            <div class="d-flex justify-content-end"> 
          <button @click="procesarFilasSeleccionadas" class="btn btn-success">Procesar seleccionados</button>
        </div>
   
        <data-table :headers="encabezados" :items="requerimientos" @selection-changed="selectedRows = $event" />
         
        </div>
    </div>
  </div>
</div>
</template>

<script>
  import DataTable from './DataTable.vue';
  import Swal from 'sweetalert2';
  import jsPDF from 'jspdf';
  import { autoTable } from 'jspdf-autotable';

  export default {
    components: {
      DataTable,
    },
    data() {
      const fechaActual = new Date();
      return {
       encabezados: [
        { title: 'Id', key: 'id' },
        { title: 'Requerimiento', key: 'descripcion' },
        { title: 'Unidad', key: 'unidad' },
        { title: 'Usuario', key: 'usuario' },
        { title: 'Mes', key: 'mes' },
        { title: 'Año', key: 'anio' },
      ],

      requerimientos: [],
        selectedRows: [],
        searchQuery: '',
      unidades: [], // Array para almacenar las unidades de la base de datos
      requerimiento: {
        descripcion: '',
        unidad: '',
        usuario: '',
        anio: fechaActual.getFullYear(),
        mes: fechaActual.getMonth() + 1 
      },
      meses: [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ]
    };
  },
  mounted() {
    this.fetchData();
  },
   created() {
    this.getrequerimientos();
  },
  methods: {
     getrequerimientos() {
      fetch('/requerimientos/obt')
        .then(response => response.json())
        .then(data => {
          this.requerimientos = data.map(requerimiento => ({...requerimiento,selected: false  }));
  })
        .catch(error => {
          console.error('Error al obtener los requerimientos:', error);
        });
    },
    fetchData() {   
      fetch('/api/unidades')
      .then(response => response.json())
      .then(data => {
        this.unidades = data;
      })
      .catch(error => {
        console.error('Error al obtener las unidades:', error);
      });
    },
    guardarRequerimiento() {
       // Construir la data para enviar al servidor
      const data = {
        requerimiento: this.requerimiento,
    dispositivos: this.dispositivos.map(dispositivo => dispositivo.id) // Obtener los IDs de todos los dispositivos
  };

  // Enviar la solicitud al servidor
  axios.post('/api/requerimientos', data)
  .then(response => {
    console.log('Requerimiento guardado:', response.data);
    Swal.fire({
      icon: 'success',
      title: '¡Éxito!',
      text: 'El requerimiento se ha guardado correctamente.'
    });
      // Limpiar el formulario
    this.requerimiento = {
      descripcion: '',
      unidad: '',
      usuario: '',
      anio: new Date().getFullYear(),
      mes: new Date().getMonth() + 1
    };
  })
  .catch(error => {
    console.error('Error al guardar el requerimiento:', error);
      // Puedes mostrar un SweetAlert de error aquí
  });
},
procesarFilasSeleccionadas() {
  if (this.selectedRows().length === 0) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor, seleccione al menos un requerimiento.'
    });
    return;
  }

  const doc = new jsPDF();

  // Encabezado del informe
  const agregarEncabezado = () => {
    doc.setFontSize(11);

    doc.text('POLICÍA DE INVESTIGACIONES DE CHILE', 10, 20);
    doc.setFontSize(11);

    doc.text('Plana Mayor Regional Aricay Parinacota', 10, 30);
    doc.setFontSize(12); 
  };
    const fechaActual = new Date();
  const fechaFormateada = `${fechaActual.getDate()}.${fechaActual.toLocaleString('default', { month: 'short' }).toUpperCase()}.${fechaActual.getFullYear()}`;
    agregarEncabezado();
const pageWidth = doc.internal.pageSize.getWidth();
  const fechaTextWidth = doc.getTextWidth(`Arica, ${fechaFormateada}`);
  const fechaXOffset = pageWidth - fechaTextWidth - 10; // 10 es el margen derecho

  // Escribir la fecha a la derecha
  doc.text(`Arica, ${fechaFormateada}`, fechaXOffset, 35); // 20 es la posición Y

  // Calcular la posición X para centrar el título
  const tituloTextWidth = doc.getTextWidth('INFORME DE TAREAS');
  const tituloXOffset = (doc.internal.pageSize.getWidth() - tituloTextWidth) / 2;

  // Escribir el título centrado
  doc.text('INFORME DE TAREAS', tituloXOffset, 40);

  // Subrayar el título
  doc.setLineWidth(0.5);
  doc.line(tituloXOffset, 42, tituloXOffset + tituloTextWidth, 42);


  // Introducción
  doc.setFontSize(10);
  const parrafo = `El presente informe detalla las tareas realizadas durante el mes de ${this.meses[fechaActual.getMonth()]} de ${fechaActual.getFullYear()} en diversas áreas de la organización. Durante este periodo, se llevaron a cabo múltiples actividades enfocadas en mejorar la infraestructura tecnológica, optimizar procesos logísticos y administrativos, y garantizar el funcionamiento adecuado de los sistemas y equipos. Las tareas se distribuyeron en diversas áreas, incluyendo la instalación de redes, configuración de equipos, traslado de mobiliario, y revisiones de sistemas de seguridad, entre otras.`;
  doc.text(parrafo, 10, 60, { maxWidth: 180, align: 'justify' });

  // Tabla
  const headers = this.encabezados.map(header => header.title);
  const data = this.selectedRows().map(row => {
    return this.encabezados.map(header => {
      if (header.key.includes('.')) {
        const keys = header.key.split('.');
        return row[keys[0]][keys[1]];
      } else {
        return row[header.key];
      }
    });
  });

  doc.autoTable({
    head: [headers],
    body: data,
    startY: 100,
    styles: {
      fontSize: 8,
      halign: 'center',
      cellPadding: 4
    },
    headStyles: {
      fillColor: [200, 200, 200]
    }
  });
   if (doc.getNumberOfPages() > 1) {
    for (let i = 2; i <= doc.getNumberOfPages(); i++) {
      doc.setPage(i);
      agregarEncabezado();
    }
  }
  // Guardar el PDF
  doc.save('informe_de_tareas.pdf');
}
}
};
</script>

<style scoped>


  @keyframes glowing {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .btn-gradient {
    background: linear-gradient(to right, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    font-weight: bold;
    letter-spacing: 1px;
    transition: all 0.3s ease;
  }

  .btn-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  .form-floating textarea.form-control {
    height: 100px;
  }
</style>