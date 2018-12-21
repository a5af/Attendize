<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Http\Requests;
use App\Models\Meal;
use Auth;
use Log;

class EventMealsController extends MyBaseController
{
  public function showMeals(Request $request, $event_id = '')
  {
    $allowed_sorts = ['type', 'date'];

    $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');
    $sort_order = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';
    $event = Event::scope()->find($event_id);

    $meals= $event->meals()->orderBy($sort_by, $sort_order)->paginate();

    $data = [
      'event' => $event,
      'meals' => $meals,
      'sort_by'    => $sort_by,
      'sort_order' => $sort_order,
    ];
    return view('ManageEvent.Meals', $data);
  }

  public function showCreateMeal($event_id) {
    return view('ManageEvent.Modals.CreateMeal', [
      'event' => Event::scope()->find($event_id),
    ]);

  }

  public function postCreateMeal(Request $request, $event_id) {
    $meal = Meal::createNew();

    if(!$meal->validate($request->all())) {
      return response()->json([
        'status'   => 'error',
        'messages' => $meal->errors(),
      ]);
    }


    $meal->type = $request->get('type');
    $meal->date = Carbon::createFromFormat('Y-m-d', $request->get('date'));;
    $meal->option = $request->get('option');
    $meal->event_id = $event_id;
    $meal->save();

    session()->flash('message', 'Successfully created meal.');

    return response()->json([
      'status'      => 'success',
      'redirectUrl' => route('showMeals', [
        'event_id' => $event_id,
      ]),
    ]);

  }

  public function showDeleteMeal($event_id, $meal_id) {
    return view('ManageEvent.Modals.DeleteMeal', [
      'event' => Event::scope()->find($event_id),
      'meal' => Meal::find($meal_id)
    ]);
  }

  public function postDeleteMeal($event_id, $meal_id) {
    $meal = Meal::find($meal_id);
    $meal->delete();

    session()->flash('message', 'Successfully deleted meal option.');

    return response()->json([
      'status'      => 'success',
      'redirectUrl' => route('showMeals', [
        'event_id' => $event_id,
      ]),
    ]);
  }

  public function showEditMeal($event_id, $meal_id) {
    return view('ManageEvent.Modals.EditMeal', [
      'event' => Event::scope()->find($event_id),
      'meal' => Meal::find($meal_id),
      'types'=> ['Breakfast', 'Brunch', 'Lunch', 'Snack', 'Dinner', 'Dessert']

    ]);
  }

  public function postEditMeal(Request $request, $event_id, $meal_id) {
    $meal = Meal::find($meal_id);

    if(!$meal->validate($request->all())) {
      return response()->json([
        'status'   => 'error',
        'messages' => $meal->errors(),
      ]);
    }

    $meal->type = $request->get('type');
    $meal->date = Carbon::createFromFormat('Y-m-d', $request->get('date'));;
    $meal->option = $request->get('option');

    $meal->update();

    session()->flash('message', 'Successfully updated meal option.');

    return response()->json([
      'status'      => 'success',
      'redirectUrl' => route('showMeals', [
        'event_id' => $event_id,
      ]),
    ]);
  }
}
