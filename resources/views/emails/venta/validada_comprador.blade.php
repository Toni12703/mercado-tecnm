@component('mail::message')
# ¡Tu compra ha sido validada!

Has comprado el producto **{{ $venta->producto->nombre }}**.

### Contacta al vendedor:
- **Correo del vendedor:** {{ $venta->producto->vendedor->email }}

Te recomendamos comunicarte con el vendedor para coordinar el envío.

@endcomponent
