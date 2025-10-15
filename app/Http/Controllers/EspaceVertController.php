<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaceVert;
use Illuminate\Support\Facades\Http;

class EspaceVertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'newest');
        $search = $request->input('search');

        $query = EspaceVert::query();
        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'superficie_asc' => $query->orderBy('superficie', 'asc'),
            'superficie_desc' => $query->orderBy('superficie', 'desc'),
            'name_asc' => $query->orderBy('nom', 'asc'),
            'name_desc' => $query->orderBy('nom', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('adresse', 'like', "%$search%")
                  ->orWhere('superficie', 'like', "%$search%")
                  ->orWhere('type', 'like', "%$search%")
                  ->orWhere('etat', 'like', "%$search%")
                  ->orWhere('besoin_specifique', 'like', "%$search%");
            });
        }

        $espacesVerts = $query->with('rapportBesoins')->get(); // Eager load rapports

        if ($request->ajax()) {
            return response()->json($espacesVerts);
        }
        return view('admin_dashboard.espaceVert', compact('espacesVerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $espacesVerts = EspaceVert::all(); // Ensure data is available
        return view('admin_dashboard.espaceVert', compact('espacesVerts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nom' => 'required|string|max:50|min:3',
            'adresse' => 'required|string|max:25|min:5',
            'superficie' => 'required|numeric',
            'type' => 'required|in:parc,jardin,toit vert,autre',
            'etat' => 'required|in:bon,moyen,mauvais',
            'besoin_specifique' => 'nullable|string',
        ]);

        try {
            // Create a new EspaceVert record
            EspaceVert::create($validatedData);

            // Redirect with success message
            return redirect()->route('espace.create')->with('success', 'Espace Vert créé avec succès !');
        } catch (\Exception $e) {
            // Redirect with error message if creation fails
            return redirect()->route('espace.create')->with('error', '"Échec de la création de l’Espace Vert. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $espaceVert = EspaceVert::findOrFail($id);
        $espacesVerts = EspaceVert::all(); // Keep this for the table
        return view('admin_dashboard.create', compact('espaceVert', 'espacesVerts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'type' => 'required|in:parc,jardin,toit vert,autre',
            'etat' => 'required|in:bon,moyen,mauvais',
            'besoin_specifique' => 'nullable|string',
        ]);

        try {
            $espaceVert = EspaceVert::findOrFail($id);
            $espaceVert->update($validatedData);
            return redirect()->route('espace.index')->with('success', 'Mise à jour effectuée avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la mise à jour de l’Espace Vert. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $espaceVert = EspaceVert::findOrFail($id);
            $espaceVert->delete();
            return redirect()->route('espace.index')->with('success', 'Espace Vert supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la suppression. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }
       /**
     * Display client page with Espace Vert data.
     */
    public function displayClient()
    {
        $espacesVerts = EspaceVert::orderBy('created_at', 'desc')->get();
        return view('client_page.client', compact('espacesVerts'));
    }
    

  public function chatbotPage()
    {
        return view('admin_dashboard.chatbot');
    }

    /**
     * Handle chatbot API request.
     */
public function chat(Request $request)
{
    $message = $request->input('message');
    if (!$message) {
        return response()->json(['error' => 'Message is required'], 400);
    }

    try {
        $response = Http::timeout(60)->post('http://localhost:11434/api/chat', [
            'model' => 'llama3.2:3b',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful chatbot for Espace Vert management. Provide information about green spaces, their types, states, and needs. Only answer within this scope.'],
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        \Log::info('Ollama Raw Response', ['body' => $response->body()]);

        if ($response->failed()) {
            \Log::error('Ollama Failed', ['status' => $response->status(), 'body' => $response->body()]);
            return response()->json(['error' => 'Failed to connect to Ollama API. Status: ' . $response->status()], 500);
        }

        $lines = array_filter(explode("\n", trim($response->body())), 'trim');
        $defaultReply = 'Je suis là pour vous aider sur les espaces verts. Pouvez-vous préciser votre question ?';
        $fullContent = '';

        foreach ($lines as $line) {
            $data = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if (isset($data['message']['content'])) {
                    $fullContent .= $data['message']['content'];
                } elseif (isset($data['content'])) {
                    $fullContent .= $data['content'];
                } elseif (is_string($data)) {
                    $fullContent .= $data;
                }
            } else {
                \Log::warning('JSON decode failed', ['line' => $line, 'error' => json_last_error_msg()]);
            }
        }

        $reply = trim($fullContent) ?: $defaultReply;

        return response()->json(['reply' => $reply]);

    } catch (\Exception $e) {
        \Log::error('Chat Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Une erreur est survenue lors du traitement de votre demande.'], 500);
    }
}



}
