    
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('{$FOLDER_NAME}');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            ${$SINGULAR_NAME} = {$MODEL}::findOrFail($d);
            ${$SINGULAR_NAME}->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'{$MODEL} order updated.',
        ];
        return response()->json($response);
    }
