<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends BaseController
{
	/**
	 * Get all CSV images
	 *
	 * @param Request $request
	 * @param String $csv_id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $csv_id)
	{
		// --
		// Get all images
		return $this->sendResponse($this->getFilteredImages(), 'success');
	}

	/**
	 * Upload and store images
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// --
		// Check validations
		$validator = Validator::make($request->all(),
			[
				'images' => 'required',
				'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
			]
		);

		if($validator->fails()) {
			return $this->sendError('Validation Error', $validator->errors());       
		}
		
		// --
		// Upload images
		if($request->has('images')) {
			$images = $request->file('images');
			
			foreach($images as $image) {
				$filename = time().rand(3, 5). '.'.$image->getClientOriginalExtension();
				$image->move('uploads/', $filename);

				Image::create([
					'user_id' => auth()->user()->id,
					'csv_id' => $request->csv_id,
					'name' => $image->getClientOriginalName(),
					'file_name' => $filename,
					'path' => 'uploads/'.$filename
				]);
			}

			// --
			// Get all images
			return $this->sendResponse($this->getFilteredImages(), 'Image Uploaded Successfully.');
		}

		return $this->sendError('Image uploading fail.');  
	}

	/**
	 * Get all user images
	 *
	 * @return array
	 */
	private function getFilteredImages() {
		$images = Image::where('user_id', auth()->user()->id)->get(array('csv_id', 'path'));

		$filterImages = [];
		if(!empty($images)) {
			foreach ($images as $key => $value) {
				if(!isset($filterImages[$value->csv_id])) {
					$filterImages[$value->csv_id] = [];
				}
				array_push($filterImages[$value->csv_id], $value->path);
			}
		}

		return $filterImages;
	}
}