<x-admin-layout title="Nuevo Ticket | SpamSafe" :breadcrumbs="[
    ['name'=> 'Dashboard', 'href'=> route('admin.dashboard')],
    ['name'=> 'Soporte', 'href'=> route('admin.tickets.index')],
    ['name'=> 'Nuevo Ticket'],
]">

    <x-wire-card title="Reportar un problema">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            Describe tu problema o duda y nuestro equipo de soporte se pondrá en contacto contigo.
        </p>

        <form action="{{ route('admin.tickets.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-wire-input
                    label="Título del problema"
                    name="title"
                    :value="old('title')"
                    placeholder="Ej. Error al guardar cita"
                    required
                />

                <x-wire-textarea
                    label="Descripción detallada"
                    name="description"
                    placeholder="Describe con el mayor detalle posible qué ocurre, en qué pantalla y qué esperabas."
                    rows="5"
                    required
                >{{ old('description') }}</x-wire-textarea>
            </div>

            <div class="flex justify-end items-center gap-2 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <x-wire-button href="{{ route('admin.tickets.index') }}" flat label="Cancelar" />
                <x-wire-button type="submit" blue label="Enviar Ticket" />
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
