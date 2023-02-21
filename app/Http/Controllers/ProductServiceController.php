<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Exports\ProductServiceExport;
use App\Imports\ProductServiceImport;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\ProductServiceUnit;
use App\Models\Tax;
use App\Models\Vender;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class ProductServiceController extends Controller
{
    public function index(Request $request)
    {

        if(\Auth::user()->can('manage product & service'))
        {
            $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            if(!empty($request->category))
            {

                $productServices = ProductService::where('created_by', '=', \Auth::user()->creatorId())->where('category_id', $request->category)->get();
            }
            else
            {
                $productServices = ProductService::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('productservice.index', compact('productServices', 'category'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create product & service'))
        {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'product')->get();
            $category     = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
            $unit         = ProductServiceUnit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $tax          = Tax::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('productservice.create', compact('category', 'unit', 'tax', 'customFields'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {

        if(\Auth::user()->can('create product & service'))
        {

            $rules = [
                'name' => 'required',
                'sku' => 'required|unique:product_services,sku',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'category_id' => 'required',
                'unit_id' => 'required',
                'type' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('productservice.index')->with('error', $messages->first());
            }

            $productService                 = new ProductService();
            $productService->name           = $request->name;
            $productService->description    = $request->description;
            $productService->sku            = $request->sku;
            $productService->sale_price     = $request->sale_price;
            $productService->purchase_price = $request->purchase_price;
            $productService->tax_id         = !empty($request->tax_id) ? implode(',', $request->tax_id) : '';
            $productService->unit_id        = $request->unit_id;
            $productService->quantity        = $request->quantity;
            $productService->type           = $request->type;
            $productService->category_id    = $request->category_id;
            $productService->created_by     = \Auth::user()->creatorId();
            $productService->save();
            CustomField::saveData($productService, $request->customField);

            return redirect()->route('productservice.index')->with('success', __('Product successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {
        $productService = ProductService::find($id);

        if(\Auth::user()->can('edit product & service'))
        {
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
                $unit     = ProductServiceUnit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $tax      = Tax::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                $productService->customField = CustomField::getData($productService, 'product');
                $customFields                = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'product')->get();
                $productService->tax_id      = explode(',', $productService->tax_id);

                return view('productservice.edit', compact('category', 'unit', 'tax', 'productService', 'customFields'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('edit product & service'))
        {
            $productService = ProductService::find($id);
            if($productService->created_by == \Auth::user()->creatorId())
            {

                $rules = [
                    'name' => 'required',
                    'sku' => 'required|unique:product_services,sku',
                    'sale_price' => 'required|numeric',
                    'purchase_price' => 'required|numeric',
                    'category_id' => 'required',
                    'unit_id' => 'required',
                    'type' => 'required',
                ];

                $validator = \Validator::make($request->all(), $rules);

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('productservice.index')->with('error', $messages->first());
                }

                $productService->name           = $request->name;
                $productService->description    = $request->description;
                $productService->sku            = $request->sku;
                $productService->sale_price     = $request->sale_price;
                $productService->purchase_price = $request->purchase_price;
                $productService->tax_id         = !empty($request->tax_id) ? implode(',', $request->tax_id) : '';
                $productService->unit_id        = $request->unit_id;
                $productService->quantity        = $request->quantity;
                $productService->type           = $request->type;
                $productService->category_id    = $request->category_id;
                $productService->created_by     = \Auth::user()->creatorId();
                $productService->save();
                CustomField::saveData($productService, $request->customField);

                return redirect()->route('productservice.index')->with('success', __('Product successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {
        if(\Auth::user()->can('delete product & service'))
        {
            $productService = ProductService::find($id);
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $productService->delete();

                return redirect()->route('productservice.index')->with('success', __('Product successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function export()
    {
        $name = 'product_service_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductServiceExport(), $name . '.xlsx');

        return $data;
    }

    public function importFile()
    {
        return view('productservice.import');
    }

//    public function import(Request $request)
//    {
//
//        $rules = [
//            'file' => 'required|mimes:csv,txt',
//        ];
//
//        $validator = \Validator::make($request->all(), $rules);
//
//        if($validator->fails())
//        {
//            $messages = $validator->getMessageBag();
//
//            return redirect()->back()->with('error', $messages->first());
//        }
//
//        $products     = (new ProductServiceImport)->toArray(request()->file('file'))[0];
//        $totalProduct = count($products) - 1;
//        $errorArray   = [];
//        for($i = 1; $i <= count($products) - 1; $i++)
//        {
//            $items  = $products[$i];
//            $vendor = Vender::where('name', $items[3])->first();
//
//            $taxes     = explode(';', $items[6]);
//            $taxesData = [];
//            foreach($taxes as $tax)
//            {
//                $taxes       = Tax::where('name', $tax)->first();
//                $taxesData[] = $taxes->id;
//            }
//
//            $taxData = implode(',', $taxesData);
//
//            $category = ProductServiceCategory::where('name', $items[7])->first();
//            $unit     = ProductServiceUnit::where('name', $items[8])->first();
////
////            $stockStausArray = \App\ProductService::$stockStatus;
////            $stockStaus      = array_search($items[9], $stockStausArray);
//
//            $productBySku = ProductService::where('sku', $items[1])->first();
//            if(!empty($productBySku))
//            {
//                $productService = $productBySku;
//            }
//            else
//            {
//                $productService = new ProductService();
//            }
//
//
//            $productService->name           = $items[0];
//            $productService->sku            = $items[1];
//            $productService->quantity       = $items[2];
//            $productService->assign_vendor  = !empty($vendor) ? $vendor->id : 0;
//            $productService->sale_price     = $items[4];
//            $productService->purchase_price = $items[5];
//            $productService->tax_id         = $taxData;
//            $productService->category_id    = !empty($category) ? $category->id : 0;
//            $productService->unit_id        = !empty($unit) ? $unit->id : 0;
//            $productService->type           = $items[9];
//            $productService->description    = $items[10];
//            $productService->created_by     = \Auth::user()->creatorId();
//
//            if(empty($vendor) || empty($taxData) || empty($category) || empty($unit) )
//            {
//                $errorArray[] = $items;
//            }
//            else
//            {
//                $productService->save();
//            }
//
//        }
//
//        $errorRecord = [];
//        if(empty($errorArray))
//        {
//
//            $data['status'] = 'success';
//            $data['msg']    = __('Record successfully imported');
//        }
//        else
//        {
//            $data['status'] = 'error';
//            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalProduct . ' ' . 'record');
//
//
//            foreach($errorArray as $errorData)
//            {
//
//                $errorRecord[] = implode(',', $errorData);
//
//            }
//
//            \Session::put('errorArray', $errorRecord);
//        }
//
//        return redirect()->back()->with($data['status'], $data['msg']);
//    }


    public function import(Request $request)
    {
        $rules = [
            'file' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $products     = (new ProductServiceImport)->toArray(request()->file('file'))[0];
        $totalProduct = count($products) - 1;
        $errorArray   = [];
        for ($i = 1; $i <= count($products) - 1; $i++) {
            $items  = $products[$i];

            $taxes     = explode(';', $items[5]);

            $taxesData = [];
            foreach ($taxes as $tax)
            {
                $taxes       = Tax::where('id', $tax)->first();
                //                $taxesData[] = $taxes->id;
                $taxesData[] = !empty($taxes->id) ? $taxes->id : 0;


            }

            $taxData = implode(',', $taxesData);
            //            dd($taxData);

            if (!empty($productBySku)) {
                $productService = $productBySku;
            } else {
                $productService = new ProductService();
            }


            $productService->name           = $items[0];
            $productService->sale_price     = $items[1];
            $productService->purchase_price = $items[2];
            $productService->quantity       = $items[3];
            $productService->tax_id         = $items[4];
            $productService->category_id    = $items[5];
            $productService->unit_id        = $items[6];
            $productService->type           = $items[7];
            $productService->description    = $items[8];
            $productService->created_by     = \Auth::user()->creatorId();

            if (empty($productService)) {
                $errorArray[] = $productService;
            } else {
                $productService->save();
            }
        }

        $errorRecord = [];
        if (empty($errorArray)) {

            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalProduct . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }


}
