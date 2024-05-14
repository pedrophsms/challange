<?php

namespace App\Http\Controllers;

use App\Mail\ExportTransportadoras;
use App\Mail\Transportadoras;
use App\Models\Transportadora;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class TransportadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transportadoras = Transportadora::orderBy('created_at', 'desc')->paginate(10)->onEachSide(2);
        return Inertia::render('Dashboard', [
            'transportadoras' => $transportadoras,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Transportadora/CreateEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Sanitize before validade
        $filters = [
            'nome' => 'trim|empty_string_to_null',
            'endereco' => 'trim|empty_string_to_null',
            'bairro' => 'trim|empty_string_to_null',
            'cidade' => 'trim|empty_string_to_null',
            'uf' => 'trim|empty_string_to_null',
            'limite_credito' => 'digit|cast:integer',
            'data_analise_credito' => 'trim|empty_string_to_null',
        ];

        $data = filter_var_array($request->all(), $filters);

        $data = (new Sanitizer($data, $filters))->sanitize();

        // Validate sanitized array data before create
        $validation = validator($data, [
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'limite_credito' => 'required|integer',
            'data_analise_credito' => 'required|date',
        ])->validate();

        $data['uuid'] = \Str::uuid();
        $data['limite_credito'] = $data['limite_credito'] / 100;

        // Create
        Transportadora::create($data);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transportadora = Transportadora::where('uuid', $id)->firstOrFail();
        $dataAnaliseCredito = $transportadora->getRawOriginal('data_analise_credito');
        $limiteCredito = $transportadora->getRawOriginal('limite_credito');
        $transportadora = $transportadora->toArray();
        $transportadora['data_analise_credito'] = \Carbon\Carbon::parse($dataAnaliseCredito)->toISOString();
        $transportadora['limite_credito'] = $limiteCredito;
        return Inertia::render('Transportadora/CreateEdit', [
            'transportadora' => $transportadora,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Sanitize before validade
        $filters = [
            'nome' => 'trim|empty_string_to_null',
            'endereco' => 'trim|empty_string_to_null',
            'bairro' => 'trim|empty_string_to_null',
            'cidade' => 'trim|empty_string_to_null',
            'uf' => 'trim|empty_string_to_null',
            'limite_credito' => 'digit|cast:integer',
            'data_analise_credito' => 'trim|empty_string_to_null',
        ];

        $data = filter_var_array($request->all(), $filters);

        $data = (new Sanitizer($data, $filters))->sanitize();

        // Validate sanitized array data before create
        $validation = validator($data, [
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'limite_credito' => 'required|integer',
            'data_analise_credito' => 'required|date',
        ])->validate();

        $data['limite_credito'] = $data['limite_credito'] / 100;

        // Update
        Transportadora::where('uuid', $id)->update($data);

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete
        Transportadora::where('uuid', $id)->delete();

        return redirect()->route('dashboard');
    }

    /**
     * Exporta todas as transportadoras por email via CSV.
     */
    public function export(Request $request)
    {
        $transportadoras = Transportadora::all();

        $csvFileName = 'transportadoras_export.csv';

        $csvData = [];
        $csvData[] = ['Nome', 'Limite de Crédito']; // Adicione os títulos das colunas aqui

        foreach ($transportadoras as $transportadora) {
            $csvData[] = [
                $transportadora->nome,
                $transportadora->limite_credito,
            ];
        }

        $csvFile = fopen($csvFileName, 'w');
        foreach ($csvData as $csvRow) {
            fputcsv($csvFile, $csvRow);
        }
        fclose($csvFile);

        // Save file on storage facade
        $csvFile = \Storage::disk('public')->put('attachments/'.$csvFileName, file_get_contents($csvFileName));
        $csvFile = \Storage::disk('public')->url('attachments/'.$csvFileName);

        // Send email
        $to = $request->email;
        $subject = 'Exportação completa';
        $message = 'Segue em anexo o arquivo CSV com as transportadoras.';

        // send email
        Mail::to($to)->send(new Transportadoras($subject, $message, $csvFile));

        return redirect()->route('dashboard');
    }

}
