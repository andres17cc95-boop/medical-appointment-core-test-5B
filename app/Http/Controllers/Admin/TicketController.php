<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Listado de tickets de soporte (tabla con ID, Usuario, Título, Estado, Fecha).
     */
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Formulario para reportar un problema (nuevo ticket).
     */
    public function create()
    {
        return view('admin.tickets.create');
    }

    /**
     * Guardar el nuevo ticket en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            'title.required' => 'El título del problema es obligatorio.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'description.required' => 'La descripción detallada es obligatoria.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = Ticket::STATUS_ABIERTO;

        Ticket::create($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Ticket enviado',
            'text' => 'Tu reporte ha sido registrado. El equipo de soporte se pondrá en contacto contigo.',
        ]);

        return redirect()->route('admin.tickets.index');
    }
}
