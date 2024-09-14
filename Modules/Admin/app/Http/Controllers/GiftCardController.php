<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\GiftCardRequest;
use Modules\Admin\Models\GiftCard;

class GiftCardController extends Controller
{
    protected CommonRepository $comRepo;

    /**
     * Initializes the GiftCardController instance.
     *
     * @throws Exception if the CommonRepository instance cannot be created
     * @return void
     */
    public function __construct()
    {
        $this->comRepo = new CommonRepository(GiftCard::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::giftcard.index');
    }

    /**
     * Handles an AJAX request to retrieve a list of gift cards.
     *
     * @param Request $request The incoming request object.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of gift cards.
     */
    public function indexAjax(Request $request)
    {

        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');
        $select  = [
            'id',
            'name',
            'code',
            'value',
            'status',
            'expiry_date',
            'customer_id',
            'created_at',
        ];

        $data = $this->comRepo->getData(
            $select,
            $search,
            $select,
            $filter,
            $sort_field,
            $sort_type,
            $limit ?? null,
            $pagination ?? null,
            ['customer']
        );
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::giftcard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCardRequest $request): RedirectResponse
    {
        try {
            $data = $request->all();
            unset($data['customer']);
            $this->comRepo->create($data);

            return redirect()->back()->with('success', 'Gift card created successfully');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = $this->comRepo->find($id);
        return view('admin::giftcard.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->comRepo->find($id);
        return view('admin::giftcard.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftCardRequest $request, $id): RedirectResponse
    {
        try {
            $data = $request->all();
            $this->comRepo->update($id, $data);
            return redirect()->route('giftcards.index')->with('success', 'Gift card updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->comRepo->delete($id);
        return redirect()->route('giftcards.index')->with('success', 'Gift card deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $this->comRepo->bulkDelete($request->ids);
        return response()->json(['success' => 'Deleted successfully.']);
    }
}
