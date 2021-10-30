<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Product;

class CommentController extends BaseController
{
    protected $comment;
    protected $reply;
    protected $product;

    public function __construct()
    {
        $this->comment = new Comment();
        $this->reply = new Reply();
        $this->product = new Product();
    }

    public function postComment()
    {
        $input = $this->request->getPost([
            'body',
            'product_id',
            'rating',
            'reply_id',
            'comment_id'
        ]);

        $input['user_id'] = user_id();

        if (!empty($input['body'])) {
            $message = '<p class="text-primary text-capitalize">Bình luận của bạn đã được đăng thành công!.</p>';
            $status = array(
                'error'  => 0,
                'message' => $message,
            );
            if ($input['comment_id'] == 0 && $input['reply_id'] == 0) {
                $this->comment->insert($input);
            } else {
                $input['comment_id'] = $this->request->getPost('comment_id');
                $this->reply->insert($input);
            }
        } else {
            $message = '<p class="text-danger text-capitalize">Lỗi: Bình luận của bạn chưa được đăng.</p>';
            $status = array(
                'error'  => 1,
                'message' => $message,
            );
        }

        return json_encode($status);
    }

    public function showComments()
    {
        if ($this->request->isAjax()) {
            $html = '';
            $input = $this->request->getPost();
            $getListComment = $this->comment->getCommentByProduct($input['product_id'], $input['page']);
            if (count($getListComment) > 0) {
                foreach ($getListComment as $item) {
                    $html .= '<div class="d-flex align-items-start mb-2">';
                    $html .= '<div class="avatar me-75">';
                    $html .= img(showUserImage($item->avatar), false, ['width' => 40, 'height' => 40, 'alt' => esc($item->fullname)]);
                    $html .= '</div>';
                    $html .= '<div class="author-info">';
                    $html .= '<h6 class="fw-bolder mb-25 text-capitalize">' . esc($item->fullname) . '</h6>';
                    $html .= '<p class="card-text">' . getDateHumanize(esc($item->created_at)) . '</p>';
                    $html .= '<p class="card-text">';
                    $html .= esc($item->body);
                    $html .= '</p>';
                    if (logged_in()) {
                        $html .= '<a href="javascript:void(0);" class="reply" id="' . esc($item->id) . '" data-body="' . esc($item->body) . '">';
                        $html .= '<div class="d-inline-flex align-items-center">';
                        $html .= '<i data-feather="corner-up-left" class="font-medium-3 me-50"></i>';
                        $html .= '<span>Reply</span>';
                        $html .= '</div>';
                        $html .= '</a>';
                    }
                    $html .= $this->showReply($input['product_id'], $item->id);
                    $html .= '</div>';
                    $html .= '</div>';
                }

                $html .= '<div class="row">';
                $html .= '<div class="col-12">';
                $html .= $this->comment->pager->links('group1', 'pager_comment');
                $html .= '</div>';
                $html .= '</div>';
            } else {
                $html .= '<div class="alert alert-primary text-center mb-0" role="alert">';
                $html .= '<div class="alert-body">';
                $html .= '<i data-feather="info" class="me-50"></i>';
                $html .= '<span class="text-capitalize">Hiện tại chưa có bình lụân nào cho bài đăng này.</span>';
                $html .= '</div>';
                $html .= '</div>';
            }

            $data['html'] = $html;
            return json_encode($data);
        }
    }

    public function showReply($product_id, $id)
    {
        if ($this->request->isAjax()) {
            $html = '';
            $getListCommentReply = $this->reply->getReplyByComment($product_id, $id);
            if (count($getListCommentReply) > 0) {
                if (count($getListCommentReply) > 2) {
                    $html .= '<div class="accordion" id="accordionComment">';
                    $html .= '<div class="accordion-item">';
                    $html .= '<h6 class="accordion-header" id="heading' . $id . '">';
                    $html .= '<button class="accordion-button collapsed text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#comment' . $id . '" aria-expanded="true" aria-controls="comment' . $id . '">';
                    $html .= ' Xem trả lời bình luận';
                    $html .= '</button>';
                    $html .= '</h6>';
                    $html .= '<div id="comment' . $id . '" class="accordion-collapse collapse" aria-labelledby="heading' . $id . '" data-bs-parent="#accordionComment">';
                    $html .= '<div class="accordion-body">';
                    $html .= '';
                }

                foreach ($getListCommentReply as $item) {
                    $html .= '<div class="d-flex align-items-start mt-2">';
                    $html .= '<div class="avatar me-75">';
                    $html .= img(showUserImage($item->avatar), false, ['width' => 40, 'height' => 40, 'alt' => esc($item->fullname)]);
                    $html .= '</div>';
                    $html .= '<div class="author-info">';
                    $html .= '<h6 class="fw-bolder mb-25 text-capitalize">' . esc($item->fullname) . '</h6>';
                    $html .= '<p class="card-text">' . getDateHumanize(esc($item->created_at)) . '</p>';
                    $html .= '<p class="card-text">';
                    $html .= esc($item->body);
                    $html .= '</p>';
                    if (logged_in()) {
                        $html .= '<a href="javascript:void(0);" class="mode-reply" id="' . esc($item->id) . '" data-commentID="' . esc($item->commentID) . '"  data-body="' . esc($item->body) . '">';
                        $html .= '<div class="d-inline-flex align-items-center">';
                        $html .= '<i data-feather="corner-up-left" class="font-medium-3 me-50"></i>';
                        $html .= '<span>Reply</span>';
                        $html .= '</div>';
                        $html .= '</a>';
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                }
            }
            if (count($getListCommentReply) > 2) {
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }

            $data['html'] = $html;
            return $html;
        }
    }
}
