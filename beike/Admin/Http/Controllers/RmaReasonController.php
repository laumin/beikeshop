<?php
/**
 * RmaController.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     TL <mengwb@opencart.cn>
 * @created    2022-08-03 21:17:04
 * @modified   2022-08-03 21:17:04
 */

namespace Beike\Admin\Http\Controllers;

use Beike\Repositories\RmaReasonRepo;
use Exception;
use Illuminate\Http\Request;

class RmaReasonController extends Controller
{
    public function index(Request $request)
    {
        $rmaReasons = RmaReasonRepo::list($request->only('name'));
        $data = [
            'rmaReasons' => $rmaReasons,
        ];

        return view('admin::pages.rma_reasons.index', $data);
    }

    public function store(Request $request): array
    {
        $rmaReason = RmaReasonRepo::create($request->only('name'));
        return json_success("创建成功", $rmaReason);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request, int $id): array
    {
        $rmaReason = RmaReasonRepo::update($id, $request->only('name'));

        return json_success("成功修改", $rmaReason);
    }

    public function destroy(int $id): array
    {
        RmaReasonRepo::delete($id);

        return json_success("已成功删除");
    }
}