<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MemberController extends ApiController
{
    /**
     * @Route("/api/members", methods="GET")
     */
    public function list(Request $request, MemberRepository $memberRepository)
    {

        $members = $memberRepository->transformAll();

        return $this->respond($members);
    }

    /**
     * @Route("/api/members/{lastname}", methods="GET")
     */
    public function search(Request $request, MemberRepository $memberRepository)
    {
        $members = $memberRepository->transformSearch("lastname", $request->get("lastname"));

        return $this->respond($members);
    }

    /**
     * @Route("/api/member/{id}", methods="GET")
     */
    public function show(Request $request, EntityManagerInterface $em, memberRepository $memberRepository)
    {
        $member = $memberRepository->find($request->get('id'));

        if (!$member) {
            return $this->respondNotFound();
        }

        return $this->respond($memberRepository->transform($member));
    }

    /**
     * @Route("/api/member", methods="POST")
     */
    public function create(Request $request, memberRepository $memberRepository, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        if (!$request) {
            return $this->respondValidationError('Please provide a valid data!');
        }

        // persist the new member
        $member = new Member;
        $member->setFirstname(trim($request->get('firstname')));
        $member->setLastname(trim($request->get('lastname')));
        $member->setEmail(trim($request->get('email')) !== "" ? trim($request->get('email')) : null);
        $member->setPhone(trim($request->get('phone')) !== "" ? trim($request->get('phone')) : null);
        $member->setCity(trim($request->get('city')));
        $member->setStreet(trim($request->get('street')));
        (!empty(trim($request->get('birthday'))) ? $member->setBirthday(
            new \DateTime(trim($request->get('birthday'))) // validation missing
        ) : "");


        $violations = $validator->validate($member);

        if (0 !== count($violations)) {

            return $this->respondValidationError($violations);
        }

        $em->persist($member);
        $em->flush();

        return $this->respondCreated($memberRepository->transform($member));
    }

    /**
     * @Route("/api/member/{id}", methods="POST")
     */
    public function update(Request $request, EntityManagerInterface $em, memberRepository $memberRepository, ValidatorInterface $validator)
    {
        $member = $memberRepository->find($request->get('id'));

        if (!$member) {
            return $this->respondNotFound();
        }

        $member->setFirstname(trim($request->get('firstname')));
        $member->setLastname(trim($request->get('lastname')));
        $member->setEmail(trim($request->get('email')) !== "" ? trim($request->get('email')) : null);
        $member->setPhone(trim($request->get('phone')) !== "" ? trim($request->get('phone')) : null);
        $member->setPhone(trim($request->get('phone')));
        $member->setCity(trim($request->get('city')));
        $member->setStreet(trim($request->get('street')));
        (!empty(trim($request->get('birthday'))) ? $member->setBirthday(
            new \DateTime(trim($request->get('birthday'))) // validation missing
        ) : "");

        $violations = $validator->validate($member);

        if (0 !== count($violations)) {

            return $this->respondValidationError($violations);
        }

        $em->persist($member);
        $em->flush();

        return $this->respondUpdated($memberRepository->transform($member));
    }

    /**
     * @Route("/api/member/{id}", methods="DELETE")
     */
    public function delete(Request $request, EntityManagerInterface $em, memberRepository $memberRepository)
    {
        $member = $memberRepository->find($request->get('id'));

        if (!$member) {
            return $this->respondNotFound();
        }

        $em->remove($member);
        $em->flush();

        return $this->respondDeleted();
    }
}
