<?php

namespace App\Http\Controllers;

use App\Http\Requests\CSVStoreRequest;
use App\Repositories\CSVRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CSVController extends Controller
{
    public function __construct(private readonly CSVRepository $repository)
    {
    }

    public function index(): View
    {
        return view('index', ['persons' => $this->repository->getPersons()]);
    }

    public function store(CSVStoreRequest $request): RedirectResponse
    {
        $filePath = $request->file('file')->getPathname();

        try {
            $this->repository->parseCSV($filePath);
            Log::info('CSV parsed');

            return back()->with('success', 'File uploaded successfully');
        } catch (ValidationException $e) {
            Log::error($e->getMessage());

            return back()->withErrors($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->withErrors('Something went wrong');
        }
    }
}
