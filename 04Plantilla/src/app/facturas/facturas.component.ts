import { Component, OnInit } from '@angular/core';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IFactura } from '../Interfaces/factura';
import { Router, RouterLink } from '@angular/router';
import { FacturaService } from '../Services/factura.service';
import Swal from 'sweetalert2';
import { catchError, tap } from 'rxjs/operators';
import { of } from 'rxjs';

@Component({
  selector: 'app-facturas',
  standalone: true,
  imports: [SharedModule, RouterLink],
  templateUrl: './facturas.component.html',
  styleUrls: ['./facturas.component.scss']
})
export class FacturasComponent implements OnInit {
  listafacturas: IFactura[] = [];

  constructor(private facturaServicio: FacturaService, private router: Router) {}

  ngOnInit(): void {
    this.cargatabla();
  }

  cargatabla() {
    this.facturaServicio.todos().subscribe({
      next: (data: IFactura[]) => {
        this.listafacturas = data;
      },
      error: (error) => {
        console.error('Error al cargar las facturas:', error);
        Swal.fire('Error', 'No se pudieron cargar las facturas.', 'error');
      },
      complete: () => {
        console.log('Carga de facturas completada');
      }
    });
  }

  eliminar(idFactura: number) {
    Swal.fire({
      title: 'Facturas',
      text: '¿Está seguro de que desea eliminar la factura?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar Factura'
    }).then((result) => {
      if (result.isConfirmed) {
        this.facturaServicio.eliminar(idFactura).pipe(
          tap((response) => {
            if (response === 1) { // Asumiendo que devuelve 1 en caso de éxito
              Swal.fire('Facturas', 'La factura ha sido eliminada.', 'success');
              this.cargatabla(); // Recargar la tabla de facturas después de eliminar
            } else {
              Swal.fire('Error', 'No se pudo eliminar la factura.', 'error');
            }
          }),
          catchError((error) => {
            console.error('Error al eliminar la factura:', error);
            Swal.fire('Error', 'Ocurrió un problema al eliminar la factura.', 'error');
            return of();  // Manejar el error devolviendo un observable vacío
          })
        ).subscribe();
      }
    });
  }

  actualizar(factura: IFactura) {
    console.log('Actualizar factura:', factura);
    // Navega a la ruta del formulario de actualización con el ID de la factura
    this.router.navigate(['editarfactura', factura.idFactura]);
  }
}