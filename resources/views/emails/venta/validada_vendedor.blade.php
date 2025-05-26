@component('mail::message')
# ¡Has realizado una venta!

El producto **{{ $venta->producto->nombre }}** ha sido validado.

### Debes enviarlo a:
- **Nombre:** {{ $venta->comprador->name }}
- **Correo:** {{ $venta->comprador->email }}

Gracias por usar nuestra plataforma.

@endcomponent