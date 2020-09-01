<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{

	public $item;

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Item_Model');

		$this->item = new Item_Model();
	}


	/**
	 * Display Data this method.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['data'] = $this->item->get_item();

		$this->load->view('layout/header');
		$this->load->view('item/list', $data);
		$this->load->view('layout/footer');
	}


	/**
	 * Show Details this method.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$item = $this->item->find_item($id);

		$this->load->view('layout/header');
		$this->load->view('item/show', array('item' => $item));
		$this->load->view('layout/footer');
	}


	/**
	 * Create from display on this method.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->load->view('layout/header');
		$this->load->view('item/create');
		$this->load->view('layout/footer');
	}


	/**
	 * Store Data from this method.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect(base_url('item/create'));
		} else {
			$this->item->insert_item();
			redirect(base_url('item'));
		}
	}


	/**
	 * Edit Data from this method.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$item = $this->item->find_item($id);

		$this->load->view('layout/header');
		$this->load->view('item/edit', array('item' => $item));
		$this->load->view('layout/footer');
	}


	/**
	 * Update Data from this method.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect(base_url('item/edit/'.$id));
		} else {
			$this->item->update_item($id);
			redirect(base_url('item'));
		}
	}


	/**
	 * Delete Data from this method.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$item = $this->item->delete_item($id);
		redirect(base_url('item'));
	}
}
