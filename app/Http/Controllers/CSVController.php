<?php

namespace App\Http\Controllers;

use App\Http\Requests\CSVStoreRequest;
use App\Repositories\CSVRepository;
use Illuminate\Http\RedirectResponse;
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
            return back()->with('success', 'File uploaded successfully');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors($e->getMessage());
        } catch (\ValidationException $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
