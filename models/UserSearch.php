<?php
// TODO probably it's better to use https://github.com/NullRefExcep/yii2-datatables instead
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 * Used with Datatables plugin
 */
class UserSearch extends Model
{
    public $draw;
    public $totalCount = 0;
    public $filteredCount = 0;
    public $start;
    public $length;

    public $order;
    public $columns;
    public $search;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['draw', 'start', 'length'], 'integer'],
            [['order', 'columns', 'search'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return array
     */
    public function search($params)
    {
        $this->load($params, '');

        $query = User::find();

        // add conditions that should always apply here
        if (Yii::$app->user->can('Reseller')) {
            $query->where(['reseller_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->length,
            ],
            'sort' => [
                'defaultOrder' => [
                    $this->columns[$this->order[0]['column']]['data'] => $this->order[0]['dir'] == 'asc'? SORT_ASC : SORT_DESC,
                ]
            ],
        ]);
        $dataProvider->pagination->setPage($this->start/$this->length);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->totalCount = $query->count();

        // search
        if (!empty($this->search['value'])) {
            $query->andFilterWhere(['like', 'email', $this->search['value']]);
        }

        $data = [];
        $this->filteredCount = $dataProvider->totalCount;
        foreach ($dataProvider->models as $model) {
            $item = [
                'id' => $model->id,
                'email' => $model->email,
//                'username' => $model->username,
                'first_name' => $model->first_name,
                'last_name' => $model->last_name,
                'active' => $model->active? 'Active' : 'Cancelled',
            ];
            if (Yii::$app->user->can('administrator')) {
                $item['reseller_id'] = $model->reseller_id? $model->reseller->email : '';
            }
            $item['other'] =
                '<form action="'.Url::to(['admin/switch-identity']).'" method="post" style="display:inline-block">
                    <input type="hidden" name="email" value="'.$model->email.'" />
                    <input type="submit" title="Login as User" class="btn btn--primary btn--sm m-t-0" value="Login" />
                </form> 
                <a href="'.Url::to(['admin/edit-user', 'id' => $model->id]).'" title="Edit User" class="btn btn--primary btn--sm background--warning" style="vertical-align: top">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>';
            $data[] = $item;
        }

        return $data;
    }
}
