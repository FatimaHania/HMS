<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Repositories\CurrencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

class CurrencyController extends AppBaseController
{
    /** @var  CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the Currency.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $currencies = $this->currencyRepository->all();

        return view('currencies.index')
            ->with('currencies', $currencies);
    }

    /**
     * Show the form for creating a new Currency.
     *
     * @return Response
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created Currency in storage.
     *
     * @param CreateCurrencyRequest $request
     *
     * @return Response
     */
    public function store(CreateCurrencyRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('currencies')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('currencies')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'is_default' => [
                Rule::unique('currencies')->where(function ($query) {
                    $query->where('branch_id' , session('branch_id'));
                    $query->where('is_default' , 1);
                }),
            ],
        ])->validate();

        $currency = $this->currencyRepository->create($input);

        Flash::success('Currency saved successfully.');

        return redirect(route('currencies.index'));
    }

    /**
     * Display the specified Currency.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }

        return view('currencies.show')->with('currency', $currency);
    }

    /**
     * Show the form for editing the specified Currency.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }

        return view('currencies.edit')->with('currency', $currency);
    }

    /**
     * Update the specified Currency in storage.
     *
     * @param int $id
     * @param UpdateCurrencyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCurrencyRequest $request)
    {
        $currency = $this->currencyRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('currencies')->ignore($currency->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('currencies')->ignore($currency->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'is_default' => [
                Rule::unique('currencies')->ignore($currency->id)->where(function ($query) {
                    $query->where('branch_id' , session('branch_id'));
                    $query->where('is_default' , 1);
                }),
            ],
        ])->validate();

        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }

        $currency = $this->currencyRepository->update($request->all(), $id);

        Flash::success('Currency updated successfully.');

        return redirect(route('currencies.index'));
    }

    /**
     * Remove the specified Currency from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }

        $this->currencyRepository->delete($id);

        Flash::success('Currency deleted successfully.');

        return redirect(route('currencies.index'));
    }
}
