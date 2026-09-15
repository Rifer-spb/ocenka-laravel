import { TPaginated } from '@/types/types';
import {TFilter, TNotary} from './types';
import Layout from '../../Layout';
import FilterForm from "@/pages/manager/phys/notaries/pages/index/FilterForm";
import Notary from "@/pages/manager/phys/notaries/pages/index/Notary";
import Pagination from "@/components/app/manager/common/pagination/Pagination";

type TProps = {
    filter: TFilter;
    notaries: TPaginated<TNotary>;
};

export default function ({ filter, notaries } : TProps) {
    return (
        <Layout>
            <div className={'notaries'}>
                <FilterForm filter={filter}/>
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
                            {notaries.data.map((notary, index) => <Notary key={index} notary={notary}/>)}
                        </div>
                        <Pagination links={notaries.links}/>
                    </>
                ) : <div>Нотариусов не найдено</div>}
            </div>
        </Layout>
    );
}
