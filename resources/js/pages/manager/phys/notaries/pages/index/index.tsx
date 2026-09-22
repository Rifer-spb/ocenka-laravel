import { TPaginated } from '@/types/types';
import {TCurrentNotary, TNotary} from './types';
import Layout from '../../Layout';
import FilterForm from "@/pages/manager/phys/notaries/pages/index/FilterForm";
import Notary from "@/pages/manager/phys/notaries/pages/index/Notary";
import Pagination from "@/components/app/manager/common/pagination/Pagination";
import './index.css';
import {useState} from "react";
import Modal from "@/components/app/manager/common/modal/Modal";
import EditForm from "@/pages/manager/phys/notaries/pages/index/EditForm";
import {getRequest} from "@/utils/api";
import { getNotary } from "@/routes/manager/phys/notaries";

type TProps = {
    regions: Record<number, string>;
    notaries: TPaginated<TNotary>;
    defaultRegionId: number;
};

export default function ({ regions, notaries, defaultRegionId } : TProps) {
    const [isShowEditModal, setIsShowEditModal] = useState<boolean>(false);
    const [currentNotary, setCurrentNotary] = useState<TCurrentNotary | null>(null);

    const handleEditNotary = (id: number) => {
        setCurrentNotary(null);
        getRequest<TCurrentNotary>(getNotary.url(id))
            .then(({ data }) => {
                setCurrentNotary(data);
                setIsShowEditModal(true);
            })
            .catch(e => console.log(e));
    };

    return (
        <Layout>
            <div className='notaries'>
                <FilterForm regions={regions} defaultRegionId={defaultRegionId} />
                {notaries.data.length ? (
                    <>
                        <div className="table">
                            <div className="tr tr-default">
                                <div className="th align-center">ФИО</div>
                                <div className="th align-center">Адрес</div>
                                <div className="th align-center">Телефон</div>
                                <div className="th align-center">E-mails</div>
                                <div className="th align-center">Комментарий</div>
                                <div className="th edit"></div>
                            </div>
                            {notaries.data.map((notary, index) =>
                                <Notary key={index} notary={notary} editHandle={handleEditNotary}/>
                            )}
                        </div>
                        <Pagination meta={notaries}/>
                        {currentNotary && (
                            <Modal
                                title='Редактирование шаблона'
                                isShow={isShowEditModal}
                                onChange={setIsShowEditModal}
                                body={<EditForm notary={currentNotary} />}
                            />
                        )}
                    </>
                ) : <div>Нотариусов не найдено</div>}
            </div>
        </Layout>
    );
}
