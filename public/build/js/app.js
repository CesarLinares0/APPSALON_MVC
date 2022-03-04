let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaAnterior(),paginaSiguiente(),consultarAPI(),idCliente(),nombreCliente(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");document.querySelector("#paso-"+paso).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){e.preventDefault(),paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar"),mostrarResumen()):(e.classList.remove("ocultar"),t.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:a,precio:o}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=a;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$ "+o;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{id:t}=e,{servicios:a}=cita,o=document.querySelector(`[data-id-servicio="${t}"]`);a.some(e=>e.id===t)?(cita.servicios=a.filter(e=>e.id!==t),o.classList.remove("seleccionado")):(cita.servicios=[...a,e],o.classList.add("seleccionado"))}function idCliente(){cita.id=document.querySelector("#id").value}function nombreCliente(){cita.nombre=document.querySelector("#nombre").value}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostarAlerta("Cerramos los fines de semana","error","#cita-alertas")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":");t[0]<10||t[0]>18?(e.target.value="",mostarAlerta("Hora no válida","error","#cita-alertas")):cita.hora=e.target.value}))}function mostarAlerta(e,t,a,o=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(a).appendChild(c),o&&setTimeout(()=>{c.remove()},8e3)}function mostrarResumen(){const e=document.querySelector("#contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostarAlerta("Faltan datos: Servicios, Fecha u Hora","error","#resumen-alertas",!1);const t=document.createElement("H3");t.textContent="Datos de la Cita",e.appendChild(t);const{nombre:a,fecha:o,hora:n,servicios:c}=cita,r=document.createElement("P");r.innerHTML="<span>Nombre:</span> "+a;const i=new Date(o),s=i.getMonth(),d=i.getDate(),l=i.getFullYear(),u=new Date(Date.UTC(l,s,d)).toLocaleDateString("es-ES",{year:"numeric",month:"long",weekday:"long",day:"numeric"}),m=document.createElement("P");m.innerHTML="<span>Fecha:</span> "+u;const p=document.createElement("P");p.innerHTML="<span>Hora:</span> "+n,e.appendChild(r),e.appendChild(m),e.appendChild(p);const v=document.createElement("H3");v.textContent="Servicios Añadidos",e.appendChild(v),c.forEach(t=>{const{id:a,precio:o,nombre:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=n;const i=document.createElement("P");i.innerHTML="<span>Precio:</span> $"+o,c.appendChild(r),c.appendChild(i),e.appendChild(c)});const h=document.createElement("BUTTON");h.classList.add("btn"),h.textContent="Reservar Cita",h.onclick=reservarCita,e.appendChild(h)}async function reservarCita(){const{id:e,fecha:t,hora:a,servicios:o}=cita,n=o.map(e=>e.id),c=new FormData;c.append("fecha",t),c.append("hora",a),c.append("usuario_id",e),c.append("servicios",n);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:c});(await t.json()).resultado&&Swal.fire({icon:"success",title:"cita registrada",text:"Hemos registrado tu cita correctamente",button:"OK"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un error al registrar la cita"})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));